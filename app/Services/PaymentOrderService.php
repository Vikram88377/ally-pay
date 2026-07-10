<?php

namespace App\Services;

use App\Helpers\ReferenceHelper;
use App\Interfaces\PaymentOrderRepositoryInterface;
use App\Traits\AuditLogTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentOrderService
{
    use AuditLogTrait;

    public function __construct(
        protected PaymentOrderRepositoryInterface $paymentOrderRepository,
        protected WebhookService $webhookService
    ) {}

    public function createOrder($merchant, array $data)
    {
        if (!$merchant) {
            throw new Exception('Merchant not found');
        }

        $data['merchant_id'] = $merchant->id;
        $data['order_id'] = ReferenceHelper::generate('ORD');
        $data['currency'] = $data['currency'] ?? 'INR';
        $data['status'] = 'pending';

        $order = $this->paymentOrderRepository->create($data);

        $this->logAudit(
            'PAYMENT_ORDER_CREATED',
            $order,
            [],
            [
                'order_id' => $order->order_id,
                'merchant_id' => $order->merchant_id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'status' => $order->status,
            ]
        );

        return $order;
    }

    public function verifyPayment(array $data)
    {
        return DB::transaction(function () use ($data) {

            $order = $this->paymentOrderRepository->findByOrderId(
                $data['order_id']
            );

            if ($order->status !== 'pending') {
                throw new Exception('Payment order already processed');
            }

            $oldValues = [
                'status' => $order->status,
                'payment_reference' => $order->payment_reference,
                'paid_at' => $order->paid_at,
            ];

            $order->update([
                'status' => $data['status'],
                'payment_reference' => $data['payment_reference'],
                'paid_at' => $data['status'] === 'success'
                    ? now()
                    : null,
            ]);

            $this->logAudit(
                'PAYMENT_VERIFIED',
                $order,
                $oldValues,
                [
                    'status' => $order->status,
                    'payment_reference' => $order->payment_reference,
                    'paid_at' => $order->paid_at,
                ]
            );

            $this->webhookService->dispatchPaymentWebhook($order);

            return $order->fresh();
        });
    }
}
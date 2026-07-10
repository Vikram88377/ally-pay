<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
class ReportController extends Controller
{
    public function payments(Request $request)
    {
        $payments = PaymentOrder::with('merchant')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.reports.payments',
            compact('payments')
        );
    }


    public function transactions(Request $request)
    {
        $transactions = WalletTransaction::with('wallet.user')
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.reports.transactions',
            compact('transactions')
        );
    }


    public function exportPayments(Request $request): StreamedResponse
{
    $payments = PaymentOrder::with('merchant')
        ->when($request->status, function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->to_date);
        })
        ->latest()
        ->get();

    $fileName = 'payment-report-' . now()->format('Y-m-d-H-i-s') . '.csv';

    return response()->streamDownload(function () use ($payments) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Order ID',
            'Payment Reference',
            'Merchant',
            'Amount',
            'Currency',
            'Status',
            'Customer Name',
            'Customer Email',
            'Created At',
        ]);

        foreach ($payments as $payment) {
            fputcsv($handle, [
                $payment->order_id,
                $payment->payment_reference,
                $payment->merchant->business_name ?? '-',
                $payment->amount,
                $payment->currency,
                $payment->status,
                $payment->customer_name,
                $payment->customer_email,
                optional($payment->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
    }, $fileName, [
        'Content-Type' => 'text/csv',
    ]);
}

public function exportTransactions(Request $request): StreamedResponse
{
    $transactions = WalletTransaction::with('wallet.user')
        ->when($request->type, function ($query) use ($request) {
            $query->where('type', $request->type);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->to_date);
        })
        ->latest()
        ->get();

    $fileName = 'wallet-transaction-report-' . now()->format('Y-m-d-H-i-s') . '.csv';

    return response()->streamDownload(function () use ($transactions) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Transaction ID',
            'User',
            'Email',
            'Type',
            'Amount',
            'Balance After',
            'Reference ID',
            'Status',
            'Created At',
        ]);

        foreach ($transactions as $transaction) {
            fputcsv($handle, [
                $transaction->id,
                $transaction->wallet->user->name ?? '-',
                $transaction->wallet->user->email ?? '-',
                $transaction->type,
                $transaction->amount,
                $transaction->balance_after,
                $transaction->reference_id,
                $transaction->status,
                optional($transaction->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
    }, $fileName, [
        'Content-Type' => 'text/csv',
    ]);
}
}
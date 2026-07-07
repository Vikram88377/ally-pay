<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\AddMoneyRequest;
use App\Http\Requests\Wallet\DeductMoneyRequest;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Exception;

class WalletController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    public function balance(Request $request)
    {
        $wallet = $this->walletService->getBalance($request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Wallet balance fetched successfully',
            'data' => $wallet,
        ]);
    }

    public function addMoney(AddMoneyRequest $request)
    {
        $wallet = $this->walletService->addMoney(
            $request->user()->id,
            $request->amount
        );

        return response()->json([
            'success' => true,
            'message' => 'Money added successfully',
            'data' => $wallet,
        ]);
    }

    public function deductMoney(DeductMoneyRequest $request)
    {
        try {
            $wallet = $this->walletService->deductMoney(
                $request->user()->id,
                $request->amount
            );

            return response()->json([
                'success' => true,
                'message' => 'Money deducted successfully',
                'data' => $wallet,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


    public function history(Request $request)
{
    $transactions = $this->walletService->history($request->user()->id);

    return response()->json([
        'success' => true,
        'message' => 'Wallet transaction history fetched successfully',
        'data' => $transactions,
    ]);
}
}
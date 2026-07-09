<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.wallets.index', compact('wallets'));
    }

    public function transactions(Request $request)
    {
        $transactions = WalletTransaction::with('wallet.user')
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->latest()
            ->paginate(10);

        return view('admin.wallets.transactions', compact('transactions'));
    }
}
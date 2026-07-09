<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\UpdateMerchantStatusRequest;
use App\Models\Merchant;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::with('user')->latest()->paginate(10);

        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(Merchant $merchant)
    {
        $merchant->load('user', 'apiKeys');

        return view('admin.merchants.show', compact('merchant'));
    }

    public function updateStatus(UpdateMerchantStatusRequest $request, Merchant $merchant)
    {
        $merchant->update($request->validated());

        return back()->with('success', 'Merchant status updated successfully');
    }
}
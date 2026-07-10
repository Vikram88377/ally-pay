<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Models\MerchantWebhookSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookSettingController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;

        $setting = $merchant->webhookSetting;

        return view(
            'merchant.webhook-settings.index',
            compact('setting')
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'callback_url' => [
                'required',
                'url',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        $merchant = auth()->user()->merchant;


        MerchantWebhookSetting::updateOrCreate(
            [
                'merchant_id' => $merchant->id,
            ],
            [
                'callback_url' => $data['callback_url'],

                'secret_key' => 
                    $merchant->webhookSetting?->secret_key
                    ?? Str::random(40),

                'is_active' => 
                    $request->boolean('is_active'),
            ]
        );


        return back()->with(
            'success',
            'Webhook settings updated successfully'
        );
    }
}
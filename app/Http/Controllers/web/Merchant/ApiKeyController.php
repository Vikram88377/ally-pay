<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Services\MerchantApiKeyService;

class ApiKeyController extends Controller
{
    public function __construct(
        protected MerchantApiKeyService $apiKeyService
    ) {}



    public function index()
    {
        $merchant = auth()->user()->merchant;

        $apiKey = $this->apiKeyService
            ->getMyKey($merchant);


        return view(
            'merchant.api-keys.index',
            compact('apiKey')
        );
    }



    public function regenerate()
    {
        $merchant = auth()->user()->merchant;


        $apiKey = $this->apiKeyService
            ->generate($merchant);


        return back()
            ->with('success',
                'API key regenerated successfully'
            )
            ->with(
                'secret_key',
                $apiKey['secret_key']
            );
    }
}
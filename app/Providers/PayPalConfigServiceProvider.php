<?php

namespace App\Providers;

use App\Models\PaymentSetting; 
use Illuminate\Support\ServiceProvider;

class PayPalConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }
    public function boot(): void
    {
        $settings = PaymentSetting::first();
            if ($settings) {
                config([
                    'paypal' => [
                        'mode'    => $settings->sandbox == 1 ? 'sandbox' : 'live',

                        'sandbox' => [
                            'client_id'     => $settings->paypal_client_id,
                            'client_secret' => $settings->paypal_secret,
                            'app_id'        => 'APP-80W284485P519543T',
                        ],

                        'live' => [
                            'client_id'     => $settings->paypal_client_id,
                            'client_secret' => $settings->paypal_secret,
                            'app_id'        => '',
                        ],

                        'payment_action' => 'Sale',
                        'currency'       => 'USD',
                        'notify_url'     => '',
                        'locale'         => 'en_US',
                        'validate_ssl'   => true,
                    ]
                ]);
            }
    }
}

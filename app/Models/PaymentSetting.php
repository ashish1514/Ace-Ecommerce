<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'paypal_client_id',
        'paypal_secret',
        'sandbox',
    ];
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as WhatsApp Gateway, Mailgun, Postmark, AWS and more.
    |
    */

    'whatsapp' => [
        'gateway_url' => env('WHATSAPP_GATEWAY_URL', 'https://whatsapp-gateway-k6vv.onrender.com/api/whatsapp/send'),
        'secret' => env('WHATSAPP_SECRET', 'E4ProTech_Secret_Key_2026_Secure'),
    ],

];

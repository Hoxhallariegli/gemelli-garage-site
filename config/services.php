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
        'gateway_url' => env('WHATSAPP_GATEWAY_URL', env('WHATSAPP_URL', 'https://maroon-dove-866256.hostingersite.com/api/whatsapp/send')),
        'secret' => env('WHATSAPP_API_SECRET', env('WHATSAPP_SECRET', 'Gemelli_Secret_Key_2026_Secure')),
    ],

];

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
        'gateway_url' => env('WHATSAPP_GATEWAY_URL', 'http://127.0.0.1:3000/api/whatsapp/send'),
        'secret' => env('WHATSAPP_SECRET', 'Gemelli_Secret_Key_2026_Secure'),
    ],

];

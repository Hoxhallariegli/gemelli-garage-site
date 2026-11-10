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
        'gateway_url' => env('WHATSAPP_GATEWAY_URL', env('WHATSAPP_URL', null)),
        'secret' => env('WHATSAPP_API_SECRET', env('WHATSAPP_SECRET', null)),
    ],

];

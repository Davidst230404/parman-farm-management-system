<?php

return [
    'whatsapp' => [
        'number' => env('CONTACT_WHATSAPP_NUMBER', '6281234567890'),
        'display' => env('CONTACT_WHATSAPP_DISPLAY', '+62 812-3456-7890'),
        'text_landing' => env('CONTACT_WHATSAPP_TEXT_LANDING', 'Halo Parman Farm, saya tertarik untuk bekerja sama.'),
        'text_admin' => env('CONTACT_WHATSAPP_TEXT_ADMIN', 'Halo Admin Parman Farm, saya butuh bantuan dengan akun saya.'),
    ],
    'email' => env('CONTACT_EMAIL', 'admin@parmanfarm.com'),
];

<?php

return [
    'paystack' => [
        'public_key'    =>  env('PAYSTACK_PUBLIC_KEY'),
        'private_key'   =>  env('PAYSTACK_PRIVATE_KEY'),
        'secret_key'    =>  env('PAYSTACK_SECRET_TEST_KEY'),

    ],
    'flutterwave' => [
        'public_key'    =>  env('FLUTTERWAVE_PUBLIC_KEY'),
        'private_key'   =>  env('FLUTTERWAVE_PRIVATE_KEY'),
 
    ],
    
];
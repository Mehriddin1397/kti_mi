<?php

return [
    // "log" writes to sms_logs and the app log. Add "eskiz", "playmobile" etc.
    // here later and bind the matching driver in AppServiceProvider.
    'driver' => env('SMS_DRIVER', 'log'),
];

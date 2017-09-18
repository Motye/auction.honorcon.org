<?php
return [
    'min' => env('BID_MIN', 99),
    'increment' => env('BID_INCREMENT', 1),
    'open' => env('BID_OPEN', '08/01/2017 00:01 AM'),
    'close' => env('BID_CLOSE', '08/15/2017 11:59 PM'),
    'skip_date_check' => env('SKIP_DATE_CHECK', false),
    'outbid-msg' => env('OUTBID_MSG', 'You have been outbid'),
];
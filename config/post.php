<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Owner Email
    |--------------------------------------------------------------------------
    |
    | This option controls the default owner email that will be used to identify
    | the User which will be the owner of posts imported from the Feed.
    |
    */

    'default_owner_email' => env('DEFAULT_POST_OWNER_EMAIL', 'admin@blog.com'),

    /*
    |--------------------------------------------------------------------------
    | Import Interval
    |--------------------------------------------------------------------------
    |
    | This defines the interval in minutes between each Feed import request.
    |
    */

    'import_interval' => (int) env('IMPORT_INTERVAL', 5)
];

<?php

return [

    'name' => 'IdeHelper',

    'env' => 'local',

    'debug' => false,

    'url' => 'http://localhost',

    'asset_url' => null,

    'timezone' => 'UTC',

    'locale' => 'en',

    'fallback_locale' => 'en',

    'faker_locale' => 'en_US',

    'key' => '1234567890',

    'cipher' => 'AES-256-CBC',

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Database\DatabaseServiceProvider::class,

        /*
         * Package Service Providers...
         */
        \Gdl2Studio\IdeHelper\IdeHelperServiceProvider::class,

    ],

];

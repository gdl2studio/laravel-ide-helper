<?php
return [
    'default'     => 'sqlite',
    'connections' => [
        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => null,
            'database'                => ':memory:',
            'prefix'                  => '',
            'foreign_key_constraints' => true,
        ],
    ],
];
<?php
    function myFunction()
    {
        return [
            [
                "callback" => function ($data)
                {
                    return true;
                }
            ],
            [
                "callback" => function ($data)
                {
                    return true;
                },
            ],
        ];
    }
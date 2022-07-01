<?php
    foo(1, new class implements Logger
    {
        public function log($message)
        {
            log($message);
        }
    }, 3);
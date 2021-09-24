<?php
    class Something {
        public function sth(): string {
            return function (int $foo) use ($bar): string {
                return $bar;
            };
        }
    }
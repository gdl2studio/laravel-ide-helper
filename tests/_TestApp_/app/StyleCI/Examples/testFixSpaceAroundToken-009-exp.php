<?php
    try {
        throw new Exception();
    } catch (Exception $e) {
        log($e);
    }
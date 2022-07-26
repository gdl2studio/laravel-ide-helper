<?php
    usort($this->fixers, function &($a, $b) use ($selfName)
    {
        return 1;
    });
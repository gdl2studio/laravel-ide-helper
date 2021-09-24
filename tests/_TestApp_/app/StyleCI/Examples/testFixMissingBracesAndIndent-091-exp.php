<?php
    while ($true)
    {
        try
        {
            throw new \Exception();
        }
        catch (\Exception $e)
        {
            // do nothing
        }
    }
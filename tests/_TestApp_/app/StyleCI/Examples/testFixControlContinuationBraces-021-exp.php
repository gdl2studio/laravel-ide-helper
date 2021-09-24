<?php
    try
    {
        throw new \Exception();
    }
    catch (\LogicException $e)
    {
        // do nothing
    }
    catch (\Exception $e)
    {
        // do nothing
    }
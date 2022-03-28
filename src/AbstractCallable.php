<?php

namespace Phpext;

abstract class AbstractCallable
{
    abstract public function call(): ?array;

    public function verify(): bool
    {
        if (\extension_loaded(static::EXT)) {
            return true;
        }
        
        \user_error(static::EXT . " not loaded", \E_USER_NOTICE);
        return false;
    }
}

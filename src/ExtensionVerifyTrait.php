<?php

namespace Phpext;

trait ExtensionVerifyTrait
{
    public function verify(): bool
    {
        if (\extension_loaded(static::EXT)) {
            return true;
        }
        
        \user_error(static::EXT . " not loaded", \E_USER_ERROR);
        return false;
    }
}

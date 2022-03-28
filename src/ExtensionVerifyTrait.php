<?php

namespace Phpext;

trait ExtensionVerifyTrait
{
    public function verify(?string $extension = null): bool
    {
        if (\extension_loaded($extension ?? static::EXT)) {
            return true;
        }
        
        \user_error(($extension ?? static::EXT) . " not loaded", \E_USER_NOTICE);
        return false;
    }
}

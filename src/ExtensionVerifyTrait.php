<?php

namespace Phpext;

trait ExtensionVerifyTrait
{
    public function verify(string $extension): bool
    {
        if (\extension_loaded($extension)) {
            return true;
        }
        
        \user_error("$extension not loaded", \E_USER_WARNING);
        return false;
    }
}

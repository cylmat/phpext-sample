<?php

namespace Phpext;

trait ExtensionVerifyTrait
{
    public function verify(string $extension): void
    {
        \extension_loaded($extension) || \user_error("$extension not loaded", \E_USER_WARNING);
    }
}

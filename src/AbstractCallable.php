<?php

namespace Phpext;

abstract class AbstractCallable
{
    private static $errors = [];

    abstract public function call(): ?array;

    public function verify(): bool
    {
        if (\extension_loaded(static::EXT)) {
            return true;
        }
        
        self::$errors[] = static::EXT;
        return false;
    }

    public static function getUnloaded(): string
    {
        return join(', ', static::$errors) . " not loaded...";
    }
}

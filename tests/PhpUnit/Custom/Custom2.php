<?php

declare(strict_types=1);

namespace PU\Custom;

use PHPUnit\Framework\TestCase;

trait CustomAssertTrait
{
    /**
     * from PHPUnit\Framework\Assert.php
     */
    public static function assertThatIsOk($expected, string $message): void
    {
        
    }
}

class ServerManagerTest extends TestCase
{
    use Custom\CustomAssertTrait;
}
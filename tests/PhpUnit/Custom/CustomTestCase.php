<?php 

declare(strict_types=1);

namespace PU\Custom;

use PHPUnit\Framework\TestCase;

class CustomTestCase extends TestCase
{
    /**
     * from PHPUnit\Framework\Assert.php
     */
    public static function assertThatIsOk($expected, string $message): void
    {
        static::assertIsString($expected);
        static::assertThat($expected, 
            self::logicalAnd(
                self::isType('string', $expected),
                self::matchesRegularExpression('/\w+/', $expected)
            )
        );
        
        $constraint = new Constraint\IsOk;
        static::assertThat($expected, $constraint, $message);
    }
}



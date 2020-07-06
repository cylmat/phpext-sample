<?php

declare(strict_types=1);

namespace PU\Custom\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint that accepts finite.
 */
final class IsOk extends Constraint
{
    public function __construct(){}
    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return 'string is "it\'s ok"';
    }
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        return $other === "it's ok" ? true : false;
    }
    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param mixed $other evaluated value or object
     */
    protected function failureDescription($other): string
    {
        #return \sprintf('%s',$this->toString());
        return parent::failureDescription($other);
    }
}
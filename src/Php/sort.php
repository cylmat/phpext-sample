<?php

declare(strict_types=1);

namespace Phpext\Php;

use Phpext\CallableInterface;

class Sort implements CallableInterface
{
    public function call(): array
    {
        return [
            $this->sort()
        ];
    }

    private function sort()
    {
        // multi-sorting method
        usort($products, function (Product $a, Product $b): int {
            return
                ($b->isInStock() <=> $a->isInStock()) * 100 + // inStock DESC
                ($b->isRecommended() <=> $a->isRecommended()) * 10 + // isRecommended DESC
                ($a->getName() <=> $b->getName()); // name ASC
        });
    }
}

class Product
{
    public function isInStock(): int
    {
        return 1;
    }

    public function isRecommended(): int
    {
        return 1;
    }

    public function getName(): int
    {
        return 1;
    }
}

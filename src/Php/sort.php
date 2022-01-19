<?php

// multi-sorting method
usort($products, function (Product $a, Product $b): int {
    return
        ($b->isInStock() <=> $a->isInStock()) * 100 + // inStock DESC
        ($b->isRecommended() <=> $a->isRecommended()) * 10 + // isRecommended DESC
        ($a->getName() <=> $b->getName()); // name ASC
});

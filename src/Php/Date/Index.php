<?php

declare(strict_types=1);

namespace Phpext\Php\Date;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call(): array
    {
        $dateStart = new \DateTime();
        $dateInterval = \DateInterval::createFromDateString('-1 day');
        $datePeriod = new \DatePeriod($dateStart, $dateInterval, 3);

        $return = [];
        foreach ($datePeriod as $date){
            // @todo
            $return[] = $date->format("Ymd");
        }

        return $return;
    }
}

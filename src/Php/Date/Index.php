<?php

declare(strict_types=1);

namespace Phpext\Php\Date;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call()
    {
        $dateStart = new \DateTime();
        $dateInterval = \DateInterval::createFromDateString('-1 day');
        $datePeriod = new \DatePeriod($dateStart, $dateInterval, 3);

        foreach($datePeriod as $date){
            // @todo
            //echo $date->format("Ymd") . "<br>";
        }
    }
}

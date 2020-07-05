<?php

declare(strict_types=1);

namespace Date;

class Index
{
    public function index()
    {
        $dateStart = new \DateTime();
        $dateInterval = \DateInterval::createFromDateString('-1 day');
        $datePeriod = new \DatePeriod($dateStart, $dateInterval, 3);

        foreach($datePeriod as $date){
            echo $date->format("Ymd") . "<br>";
        }
    }
}

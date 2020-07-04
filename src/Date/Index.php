<?php

declare(strict_types=1);

namespace Date;

class Index
{
    public function index()
    {
        $dateStart = new \DateTime();
        $dateInterval = \DateInterval::createFromDateString('-1 day');
        $datePeriod = new \DatePeriod($dateStart, $dateInterval, 30);
    }
}

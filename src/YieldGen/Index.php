<?php declare(strict_types = 1);

namespace YieldGen; # keyword

class Index
{
    public function yielding()
    {
        echo implode(' ', (new YieldManager)->useGen(['first:0','second:1','third:2']));
    }

    public function yielding2()
    {
        echo (new YieldManager)->useNewGen(['first:0','second:1','third:2']);
    }

    public function tasks()
    {
        (new TaskRunner)->run();
    }
}

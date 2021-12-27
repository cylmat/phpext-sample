<?php

declare(strict_types=1);

namespace Phpext\Php\YieldGen;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call()
    {
        //@todo 
        // $this->yielding();
    }

    public function yielding()
    {
        echo implode(' ', (new YieldManager())->useGen(['first:0','second:1','third:2']));
    }

    public function yielding2()
    {
        echo (new YieldManager())->useNewGen(['first:0','second:1','third:2']);
    }

    public function tasks()
    {
        (new TaskRunner())->run();
    }
}

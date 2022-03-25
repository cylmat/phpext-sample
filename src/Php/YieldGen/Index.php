<?php

declare(strict_types=1);

namespace Phpext\Php\YieldGen;

use Phpext\CallableInterface;

class Index implements CallableInterface
{
    public function call(): array
    {
        //@todo 
        // $this->yielding();

        return ['987'];
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

<?php

declare(strict_types=1);

namespace Phpext\Php\YieldGen;

use Phpext\AbstractCallable;

class YieldGen extends AbstractCallable
{
    public function call(): array
    {
        return [
            $this->yielding(),
            $this->yielding2(),
            $this->tasks()
        ];
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

<?php

declare(strict_types=1);

namespace Phpext\Php\YieldGen;

use Phpext\CallableInterface;

class YieldGen implements CallableInterface
{
    public function call(): array
    {
        return [
            $this->yielding(),
            $this->yielding2(),
            $this->tasks()
        ];
    }

    public function yielding(): string
    {
        return implode(' ', (new YieldManager())->useGen(['first:0','second:1','third:2']));
    }

    public function yielding2(): string
    {
        return (new YieldManager())->useNewGen(['first:0','second:1','third:2']);
    }

    public function tasks()
    {
        return (new TaskRunner())->run();
    }
}

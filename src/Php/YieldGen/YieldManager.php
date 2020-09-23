<?php

declare(strict_types=1);

namespace YieldGen;

class YieldManager
{
    public function useGen(): array
    {
        $res = [];
        foreach ($this->genOneToThree() as $key => $value) {
            $res[] = "$key:$value";
        }
        return $res;
    }

    private function genOneToThree(): \Generator
    {
        $keys = ["first", "second", "third"];
        for ($i = 0; $i < 3; $i++) {
            // Note that $i is preserved between yields.
            yield $keys[$i] => $i;
        }
    }

    public function useNewGen(): string
    {
        $res = '';

        // Start using the generator
        $generatorDataFromServer = $this->generateDataFromServerDemo();
        foreach ($generatorDataFromServer as $numberOfRuns) {
            if ($numberOfRuns < 10) {
                $res .= $numberOfRuns . ":";
            } else {
                $generatorDataFromServer->send(true); //sending data to the generator
                $res .= $generatorDataFromServer->current(); //accessing the latest element (hinting how many bytes are still missing).
            }
        }
        return $res;
    }

    private function generateDataFromServerDemo(): \Generator
    {
        $indexCurrentRun = 0;
        //In this example in place of data from the server, I just send feedback
        //every time a loop ran through.
        $timeout = false;
        while (!$timeout) {
            $timeout = yield $indexCurrentRun;
            // Values are passed to caller. The next time the
            //generator is called, it will start at this statement. If send() is used, $timeout will take this
            //value.
            $indexCurrentRun++;
        }
        //yield 'X of bytes are missing. </br>';
    }
}

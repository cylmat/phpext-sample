<?php

namespace YieldGen;

class YieldManager
{
    function use_gen(): array
    {
        $res = [];
        foreach ($this->gen_one_to_three() as $key => $value) {
            $res[] = "$key:$value";
        }
        return $res;
    }

    private function gen_one_to_three(): \Generator
    {
        $keys = ["first", "second", "third"];
        for ($i = 0; $i < 3; $i++) {
            // Note that $i is preserved between yields.
            yield $keys[$i] => $i;
        }
    }




    function use_new_gen(): string
    {
        $res = '';

        // Start using the generator
        $generatorDataFromServer = $this->generateDataFromServerDemo();
        foreach($generatorDataFromServer as $numberOfRuns) {
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
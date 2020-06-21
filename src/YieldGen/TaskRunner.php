<?php

namespace YieldGen;

class TaskRunner
{
    protected $tasks;
    
    public function __construct()
    {
        $this->tasks = new \SplQueue;

        $this->addTask( $this->task1() );
        $this->addTask( $this->task2() );
        $this->addTask( $this->task3() );
    }
    
    public function addTask(\Generator $task): void
    {
        $this->tasks->enqueue($task);
    }
    
    public function run(): void
    {
        $total=[];
        while(!$this->tasks->isEmpty())
        {
            //prend le dernier
            $task = $this->tasks->dequeue();
            $task->send('Hello world');
            
            if($task->valid()) {
                //rajoute au debut
                $this->addTask($task);
            }
        }
    }



    /* private */

    private function task1(): \Generator
    {
        for($i=0; $i<3; $i++) 
        {
            $test = yield 'alpha'.$i;
        }
    }

    private function task2(): \Generator
    {
        for($i=99; $i<103; $i++) 
        {
            $superTop = yield 'blob'.$i;
        }
    }

    private function task3(): \Generator
    {
        for($i=6; $i<9; $i++) 
        {
            $superTop = yield 'carton'.$i;
        }
    }
}
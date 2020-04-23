<?php

namespace Start\Controllers;

class IndexController 
{
    public function indexAction($p1=9, $p2=2)
    {
        return [
            'john' => 'wayne'
        ];
    }
}
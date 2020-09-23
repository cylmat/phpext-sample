<?php

declare(strict_types=1);

namespace Auth;

class Index
{
    
    public function basic()
    {
        (new Digest())->handleBasic();
    }


    
    public function digest()
    {
        (new Digest())->handleDigest();
    }
}

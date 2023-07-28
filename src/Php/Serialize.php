<?php

declare(strict_types=1);

namespace Phpext\Php;

use Phpext\CallableInterface;

class TestSerializable implements \Serializable
{
    public function __construct(private int $alpha, private int $beta) {}
    
    // without any function
    
    // called first and alone, instead of Interface an __sleep
    // string(51) "O:16:"TestSerializable":2:{i:0;i:567;s:1:"b";i:99;}"
    public function __serialize(): array { var_dump('__seri()'); return [$this->alpha, 'b' => $this->beta]; }
    public function __unserialize(array $array): void { var_dump('__unseri()');
        $this->alpha = $array[0]; $this->beta = $array['b'];
    }
    
    // called if no "__" functions
    // string(34) "C:16:"TestSerializable":6:{567.99}"
    public function serialize(): string { var_dump('::seri()'); return $this->alpha.'.'.$this->beta; }
    public function unserialize(string $string): void { var_dump('::unseri()');
        $ex = \explode('.', $string); $this->alpha = $ex[0]; $this->beta = $ex[1];
    }
    
    // called if no Serializable and no __function
    // string(63) "O:16:"TestSerializable":1:{s:22:"TestSerializable";i:99;}"
    public function __sleep(): array { var_dump('__sleep()'); return ['beta']; }
    public function __wakeup(): void { var_dump('__wakeup()'); } // alpha: uninitialized(int)
}

class Serialize implements CallableInterface
{
    public function call(): array
    {
        return [
            $this->serialize(),
        ];
    }

    private function serialize(): array
    {
        $testSerializable = new TestSerializable(567, 99);
        $seri = \serialize($testSerializable);
        $unser = \unserialize($seri);
        return [$seri];
        //var_dump($unser);
    }
}

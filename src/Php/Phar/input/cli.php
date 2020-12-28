<?php
include '../MyLib.php';
echo 'cli'.PHP_EOL;
class Input
{
    static function handle()
    {
        global $argv;
        //php usephar.php -d=5 --dump=6
        $opt = getopt("d::", ["dump::"]);
        return $opt;
    }
}
$l = new MyLib;
$i = Input::handle();
$l->addhandled($i);
$l->dump();
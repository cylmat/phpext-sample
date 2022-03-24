<?php

namespace Phpext\Php\Stream;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call(): array
    {
        // @todo

        return [];
    }

    /**
     * Exemple #5 php://memory et php://temp ne sont pas réutilisables
     */
    function filter($data)
    {
        stream_filter_register('stars_filter', __NAMESPACE__ . '\StarsFilter');

        $temp = fopen("php://memory", 'rw');
        fputs($temp, $data);

        stream_filter_append($temp, 'stars_filter');

        rewind($temp);
        $r = fread($temp, 4096);
        rewind($temp);
        while(!feof($temp)) {
            echo fgets($temp);
        }
        fclose($temp);
        
    }

    # https://www.php.net/manual/fr/wrappers.php
    # https://www.php.net/manual/fr/context.php
    function wrapper(string $text, string $add)
    {
        stream_wrapper_register ( 'add', __NAMESPACE__."\AddWrapper", 0);
        $handle = fopen("add://testing", 'w');
        fwrite($handle, $text);
        fwrite($handle, $add);
        fclose($handle);

        $handle = fopen("add://testing", 'r');
        $r = fread($handle, 4096);
        fclose($handle);
        echo $r;

        unlink("add://testing");
    }

    function wrapperTwo(int $one, int $two)
    {
        stream_wrapper_register('var', __NAMESPACE__.'\VarStream') or die("Failed to register protocol");

        $fp = fopen("var://testing_point", 'r+');
        fwrite($fp, (string)$one);
        fwrite($fp, (string)$two);
        echo fgets($fp);
        fclose($fp);
        $fp = fopen("var://testing_point", 'r+');
        echo fgets($fp);
        
        fclose($fp);
    }

}

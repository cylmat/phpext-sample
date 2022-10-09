<?php

declare(strict_types=1);

namespace Phpext\Php;

use Phpext\CallableInterface;

class Headers implements CallableInterface
{
    public function call(): array
    {
        return [];
    }

    private function download()
    {
        $file = 'picture.gif';

        if (file_exists($file)){
            header('Content-Description:FileTransfer');
            header('Content-Type:application/octet-stream');
            header('Content-Disposition:attachment;filename="'.basename($file).'"');
            header('Expires:0');
            header('Cache-Control:must-revalidate');
            header('Pragma:public');
            header('Content-Length:'.filesize($file));
            readfile($file);
            exit;
        }
    }
}
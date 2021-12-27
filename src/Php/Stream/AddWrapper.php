<?php

namespace Phpext\Php\Stream;

class AddWrapper 
{
    // this will be modified by PHP to show the context passed in the current call.
    public $context;

    private $url;

    // this is used in this example internally to store the URL
    private $buffer;

    // when fopen() with a protocol for this wrapper is called, this method can be implemented to
    //store data like the host.
    public function stream_open(string $path, string $mode, int $options, ?string &$openedPath): bool 
    {
        $url = parse_url($path);
        if($url === false) {
            return false;
        }

        $this->url = $url['host'];

        $this->buffer = '';
        return true;
    }

    public function stream_read( int $count ): string
    {
        $this->buffer = file_get_contents(__DIR__.'/'.$this->url);
        return $this->buffer;
    }

    public function stream_eof(): bool
    {
        #only one line
        return true;
    }

    // handles calls to fwrite() on this stream
    # important: return size of input data !
    public function stream_write(string $data): int 
    {
        $added_data = 'AddStream: ' . $data;
        $this->buffer .= $added_data;
        file_put_contents(__DIR__.'/'.$this->url, $this->buffer);
        return strlen($data);
    }

    // handles calls to fclose() on this stream
    public function stream_close() 
    {
        $this->buffer = null;
    }

    /**
     * response to fflush() 
     */
    public function stream_flush(): bool
    {
        return false;
    }

    // fallback exception handler if an unsupported operation is attempted.
    // this is not necessary.
    public function __call($name, $args) 
    {
        throw new \RuntimeException("This wrapper does not support $name");
    }

    public function unlink(string $path): bool
    {
        $url = parse_url($path);
        if($url === false) {
            return false;
        }

        return unlink(__DIR__.'/'.$url['host']);
    }
}

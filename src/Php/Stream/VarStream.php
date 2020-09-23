<?php

namespace Stream;

/**
 * file_get_contents(var://alpha) => $alpha
 */
class VarStream implements StreamWrapperInterface
{
    /**
     * Variable
     */
    private $data;
    /**
     * opions
     */
    private $options; //change behavior with options

    /**
     * Met fin au stream when called with feof()
     */
    public function stream_eof(): bool
    {
        return true;
    }

    /**
     * FIRST
     * Call with fopen by fopen, fsockopen, etc...
     */
    public function stream_open(string $path, string $mode='rb', int $options=0, ?string &$opened_path=''): bool
    {
        $varname = parse_url($path)['host'];
        return true;
    }

    /**
     * Used for Rewing()
     */
    public function seek()
    {
    }

    /**
     * Readed with fread....
     */
    public function stream_read(int $count)
    {
        return $this->data;
    }

    public function stream_stat(): array
    {
        return [];
    }

    /**
     * int: addition
     * string: append
     * 
     * @return int nombre de donnée écrites
     */
    public function stream_write(string $data): int
    {
        $type = 'string';
        if(ctype_digit($data)){
            $type = 'int';
            $data = (int)$data;
        } 
        
        switch($type) { 
            case 'int': $this->data = null===$this->data ? $data : $this->data + $data;
                return strlen($data);
            case 'string': $this->data = null===$this->data ? $data : $this->data . $data;
                return strlen($data);
            default: 
                return 0;
        }
    }

    //function stream_metadata($path, $option, $var) 
}

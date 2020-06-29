<?php

namespace Stream;

//Iterate bzip logs

class Index
{
    function index()
    {
        $dateStart = new \DateTime();
        $dateInterval = \DateINterval::createFromDateString('-1 day');
        $datePeriod = new \DatePeriod($dateStart, $dateInterval, 30);

        foreach ($datePeriod as $date) {
            $file = 'sftp://USER:PASS@rsync.net/' . $date->format('Y-m-d') . 'log.bz2';
            if (file_exists($file)) {    
                $handle = fopen($file, 'rb');
                stream_filter_append($handle, 'bzip2.decompress');
                while (feof($handle) !== true) {
                    $line = fgets($handle);
                    if (strpos($line, 'www.exemple.com') !== false) {
                        fwrite(STDOUT, $line);
                    }
                }
                fclose($handle);
            }
        }
    }

    function stream()
    {
        //////////////////////
        stream_filter_register('dirty_word_filter', 'DirtyWordsFilter');

        $handle = fopen('data.txt', 'rb');
        stream_filter_append($handle, 'dirty_words_filter');

        while (feof($handle) !== true) {
            echo fgets($handle);
        }
        fclose($handle);
    }
}





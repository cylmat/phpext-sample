<?php

namespace Stream;

class DirtyWordsFilter extends \php_user_filter
{
    /**
     * resource $in incoming bucket
     * resource $out outgoing bucket brigade
     * int $consumed number of bytes consumed
     * bool $closing last bucket in stream?
     */
    public function filter($in, $out, &$consumed, $closing)
    {
        $words = array('grime', 'dirt', 'grease');
        $wordData = array();
        foreach ($words as $word) {
            $replacement = array_fill(0, mb_strlen($word), '*');
            $wordData[$word] = implode('', $replacement);
        }
        $bad = array_keys($wordData);
        $good = array_values($wordData);

        while ($bucket = stream_bucket_make_writeable($in)) {
            $bucket->data = str_replace($bad, $good, $bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}


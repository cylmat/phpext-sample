<?php

namespace Stream;

/*
 https://www.php.net/manual/fr/context.php
 https://www.php.net/manual/fr/wrappers.php.php
*/
/*
 * stream_bucket_make_writeable ( resource $brigade ) : object
 * stream_bucket_new ( resource $stream , string $buffer ) : object
 * stream_bucket_append ( resource $brigade , object $bucket ) : void
 * stream_bucket_prepend ( resource $brigade , object $bucket ) : void
 */
class StarsFilter extends \php_user_filter
{
    /**
     * resource $in incoming bucket
     * resource $out outgoing bucket brigade
     * int $consumed number of bytes consumed
     * bool $closing last bucket in stream?
     */
    public function filter($ress_in, $ress_out, &$consumed, $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($ress_in)) {
            $bucket->data = str_replace('stars','*****',$bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($ress_out, $bucket); 
        }
        return PSFS_PASS_ON;
    }
}

/* 
 ref: https://www.php.net/manual/en/stream.constants.php
    PSFS_PASS_ON 	Return Code indicating that the userspace filter returned buckets in $out.
    PSFS_FEED_ME 	Return Code indicating that the userspace filter did not return buckets in $out (i.e. No data available).
    PSFS_ERR_FATAL 	Return Code indicating that the userspace filter encountered an unrecoverable error (i.e. Invalid data received).
    PSFS_FLAG_NORMAL 	Regular read/write.
    PSFS_FLAG_FLUSH_INC 	An incremental flush.
    PSFS_FLAG_FLUSH_CLOSE 	Final flush prior to closing.
*/
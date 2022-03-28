<?php

declare(strict_types=1);

function mb_conv()
{
    //$binarydata = \pack("nvc*", 0x1234, 0x5678, 65, 66);

    //How to use :
    echo "Get string from numeric DEC value\n";
    var_dump(mb_chr(50319, 'UCS-4BE'));
    var_dump(mb_chr(271));

    echo "\nGet string from numeric HEX value\n";
    var_dump(mb_chr(0xC48F, 'UCS-4BE'));
    var_dump(mb_chr(0x010F));

    echo "\nGet numeric value of character as DEC string\n";
    var_dump(mb_ord('ď', 'UCS-4BE'));
    var_dump(mb_ord('ď'));

    echo "\nGet numeric value of character as HEX string\n";
    var_dump(dechex(mb_ord('ď', 'UCS-4BE')));
    var_dump(dechex(mb_ord('ď')));

    echo "\nEncode / decode to DEC based HTML entities\n";
    var_dump(mb_htmlentities('tchüß', false));
    var_dump(mb_html_entity_decode('tch&#252;&#223;'));

    echo "\nEncode / decode to HEX based HTML entities\n";
    var_dump(mb_htmlentities('tchüß'));
    var_dump(mb_html_entity_decode('tch&#xFC;&#xDF;'));
}

if (!function_exists('mb_internal_encoding')) {
    function mb_internal_encoding($from_encoding = null, $encoding = null)
    {
        return ($from_encoding === null) ? iconv_get_encoding() : iconv_set_encoding($encoding);
    }
}

if (!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($str, $to_encoding, $from_encoding = null)
    {
        return iconv(
            ($from_encoding === null) ? mb_internal_encoding() : $from_encoding,
            $to_encoding,
            $str
        );
    }
}

if (!function_exists('mb_chr')) {
    function mb_chr($ord, $encoding = 'UTF-8')
    {
        if ($encoding === 'UCS-4BE') {
            return pack("N", $ord);
        } else {
            return mb_convert_encoding(mb_chr($ord, 'UCS-4BE'), $encoding, 'UCS-4BE');
        }
    }
}

//GoalKicker.com – PHP Notes for Professionals 270
if (!function_exists('mb_ord')) {
    function mb_ord($char, $encoding = 'UTF-8')
    {
        if ($encoding === 'UCS-4BE') {
            list(, $ord) = (strlen($char) === 4) ? @unpack('N', $char) : @unpack('n', $char);
            return $ord;
        } else {
            return mb_ord(mb_convert_encoding($char, 'UCS-4BE', $encoding), 'UCS-4BE');
        }
    }
}

if (!function_exists('mb_htmlentities')) {
    function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8')
    {
        return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
            return sprintf($hex ? '&#x%X;' : '&#%d;', mb_ord($match[0]));
        }, $string);
    }
}

if (!function_exists('mb_html_entity_decode')) {
    function mb_html_entity_decode($string, $flags = null, $encoding = 'UTF-8')
    {
        return html_entity_decode($string, ($flags === null) ? ENT_COMPAT | ENT_HTML401 : $flags, $encoding);
    }
}

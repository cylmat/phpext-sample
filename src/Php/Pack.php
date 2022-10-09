<?php


declare(strict_types=1);

namespace Phpext\Php;

use Phpext\CallableInterface;

class Pack implements CallableInterface
{
    public function call(): array
    {
        return [
            $this->pack(),
            $this->my_uuencode('data'),
            $this->binary(),
            $this->hex_dump('data')
        ];
    }

    private function pack()
    {
        $bin = pack("s*", 0x5432); // => 21554
        var_dump(unpack('v',$bin)); //21554 
        var_dump(unpack('n',$bin)); //12884 (0x3254)
        var_dump(unpack('c1un/c1deux', $bin)); //un:50, deux:84
        var_dump(unpack('H2un/H2deux', $bin)); //un:32, deux:54
        echo bin2hex($bin).PHP_EOL; //3254

        /**
         * https://www.php.net/manual/fr/regexp.reference.escape.php
         * \n => \x0C     \r => \x0D      \t => \x09
         *
         * https://www.php.net/manual/fr/regexp.reference.unicode.php
         * https://www.regular-expressions.info/unicode.html
         */
        /**
         * ref: https://perldoc.perl.org/perlpacktut
         * - Usage: Input and output accessing some file, a device, or a network connection. 
         * - Passing data to some system call that is not available as a Php function. 
         * - Text processing 
         */

        /**
         * Can use bin2hex() | hex2bin() => convert Char By Char
         *  or
         * From Math, use: bindec(dechex())
         * bindec(), octdec(), hexdec() or base_convert()
         */

        $A        = mb_chr(65); // ord('A') = 65
        $_41      = dechex('65'); 
        $_101     = decoct('65'); // "\101"
        $_1000001 = decbin('65'); //
        $C        = "\u{0043}";
        $A_js = json_decode('"\u0041"');
        $T    = mb_convert_encoding("&#x54;", 'UTF-8', 'HTML-ENTITIES');
        $F    = mb_convert_encoding("\x00\x46", 'UTF-8', 'UTF-16BE');
        $A_8  = html_entity_decode('&#65;', 0, 'UTF-8'); 
        $A_16 = html_entity_decode('&#x0041;', 0, 'UTF-8');

        // LE: Little endian (classic: MSB to LSB)
        // BE: Big endian (inverted: LSB to MSB)
        $I    = iconv('UTF-16BE', 'UTF-8', "\x00\x49"); 


        // Pack: [DATA] to BINARY
        $AA    = pack("H2H2", 0x41, 0x41); 
        $_6565 = bin2hex($AA);
        $AB    = pack("C*", 65, 66); //unsigned
        $_4142 = bin2hex($AB);
        $_1234_7856_41_42 = bin2hex(pack("nvc*", 0x1234, 0x5678, 65, 66)); //

        $NO = pack( 's', 20302 ); //78 79 => 4f 4e => 01001111 01001110
        $NO = hex2bin("4e4f");

        /**
         * String 
         */
        $prAb = pack( 'AACA', 'p', 'r', 65, 'b' );
        ['p'=>$p,'r'=>$r,'A'=>$A,'b'=>$b] = unpack( 'Zp/Zr/AA/Zb', $prAb );
        ['pr'=>$pr,'A'=>$A,'b'=>$b] = unpack( 'Z2pr/AA/Zb', $prAb );

        /**
         * UNPACK
         */
        $raw = "01/24/2001 Zed's Camel Emporium                    1147.99";
        ['date'=>$date,'text'=>$text,'price'=>$price] = unpack("Z10date/Z41text/Z7price", $raw); //Z: string with ending null

        /**
         * MB CONVERTION
         * Convertis le charactère unicode 0x20ac en '€' et récupère chaque caractère associé
         */
        $_8364 = mb_ord("€", 'UTF-8');
        $euro_array_bits = unpack('C*', "€" ); // '€' = &#8364;
        /**********************
         * *$euro8 = unpack('C*', mb_chr(0x20ac, 'UTF-8') ); // '€' = &#8364;

        [,$e2,$_82,$ac] = array_map(function($v){ return dechex($v); }, $euro8);
        $euro16 = unpack('C*', mb_chr(0x20ac, 'UTF-16') ); // '€' = &#57986;   affiche ' '
        [,$_20,$_ac] = array_map(function($v){ return dechex($v); }, $euro16);
        *///////////////

        /**
         * SAMPLE USE
         */
        # Convert IP address for socket functions
        $ip_data = pack( "N", ip2long("123.4.5.6")); //2063860998(bin) 7B040506(hex)
        $ip = long2ip(unpack("Nip", $ip_data)['ip']);

        # Count the bits in a chunk of memory (e.g. a select vector)
        //unpack( '%32b*', $mask );

        # Determine the endianness of your system
        /*****************
         * $is_little_endian = unpack( 'c', pack( 's', 1 ) );
        $is_big_endian    = unpack( 'xc', pack( 's', 1 ) );
        ****************/

        # Determine the number of bits in a native integer
        $bits = unpack( 'H*', 1 );
        //d(strlen($bits[1]));

        $i = 1;
        $i = base_convert($i,10,2);
        $x = str_replace(0,'',$i);
        $c = strlen($x);



        # Prepare argument for the nanosleep system call
        //my $timespec = pack( 'L!L!', $secs, $nanosecs );

        # Pulling digits out of nowhere...
        /*print unpack( 'C', pack( 'x' ) ),
            unpack( '%B*', pack( 'A' ) ),
            unpack( 'H', pack( 'A' ) ),
            unpack( 'A', unpack( 'C', pack( 'A' ) ) ), "\n";*/

        # One for the road ;-)
        //my $advice = pack( 'all u can in a van' );

        /************
         * samples
         * https://docstore.mik.ua/orelly/webprog/pcook/ch01_14.htm
         ************/
        $packed = pack('s*',1,1153,7,4,0xa3a2); 
        $hex = bin2hex($packed); //0100 8104 0700 0400 a2a3
        //d(unpack("C*", $packed)); //1 0 129 4 7 0 4 0 162 163

        $packed = pack('c*',1,11,7,4,0xa1); 
        //echo bin2hex($packed)."\n"; //01 0b 07 04 a1

        $packed = pack('H*H*H*', 0x05, 0x05, 0x894); //hexdec(894) = 2196
        //echo bin2hex($packed)."\n";  //50 50 2196

        // return           182, 7, 106, 0, 65, 110, 213, and 127 
        $packed = pack('S4',1974,   106,    28225,   32725); 


        /****************
         * DEBUGGING pack
         ****************/

        $types = [
            'h', //hex string lsb
            'H', //hex msb
            'c', 
            'C',  //signed char
            'v', //short 16 LE
            'n', //shart 16 BE,
            'A',
        ];

        //$data = 0x4150; //65
        //echo "0x4148"."\t"; //.join("\t",$types), "\n";
        //$txt = '';

        //head
        /*foreach($types as $t) {
            $p = pack($t.'*', $data);
            $txt .= "[$t] \"$p\"". (strlen($p)>1 ? "" : "\t") ."\t";   
        } $txt.="\n";
            
        // PACK
        foreach($types as $t) {
            $packed = pack($t.'*', $data);
            
            // UNPACK
            $txt .= 'unpk('.$t.")\t";
            foreach($types as $t) {
                $u = unpack($t.'*', $packed);
                $join = join("-", $u);
                $txt .= $join . (strlen($join)>7 ? "" : "\t") . "\t";
            }
            $txt .= "\n";
        }
        echo $txt;*/


        /********************
         *  sample
         * https://docstore.mik.ua/orelly/webprog/pcook/ch01_14.htm
         *********************/

        $packed = pack('s*',1,9,7,4,0xaa); //,106,28225,32725); // string(8) "jAn"
        //echo bin2hex($packed)."\n"; //0100 0900 0700 0400 aa00
        //$nums = unpack('n2/n2',$packed); 
        //d($nums);
    }

    /******************
     * Dump hexa values
     *****************/
    private function hex_dump($data, $newline="\n")
    {
        static $from = '';
        static $to = '';

        static $width = 16; # number of bytes per line

        static $pad = '.'; # padding for non-visible characters

        if ($from==='')
        {
            for ($i=0; $i<=0xFF; $i++)
            {
            $from .= chr($i);
            $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
            }
        }

        $hex = str_split(bin2hex($data), $width*2);
        $chars = str_split(strtr($data, $from, $to), $width);

        $offset = 0;
        foreach ($hex as $i => $line)
        {
            echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2)) . ' [' . $chars[$i] . ']' . $newline;
            $offset += $width;
        }
    }

    private function my_uuencode ( string $data )
    { //: string|false 
        $un = unpack("c*", $data); //79, 104, 33
        $bin_str = join('', array_map(function($v){ return str_pad(decbin($v), 8, '0', STR_PAD_LEFT); }, $un));
        
        while(strlen($bin_str)%6) {
            $bin_str .= '0';
        }
        
        $bin_split = str_split($bin_str, 6); //100111, 111010, ...
        $new_str = array_map(function($v){ return pack('C*', bindec($v)+32); }, $bin_split);
        return join('', $new_str);
    }

    /**
     * Binary
     */
    private function binary()
    {
        pack('H*', base_convert('01000001 01000010 01000011', 2, 16)); //ABC
        base_convert(unpack('H*', 'ABC')[1], 16, 2); //1000001 01000010 01000011
    }
}
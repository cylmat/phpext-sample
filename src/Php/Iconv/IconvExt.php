<?php

declare(strict_types=1);

namespace Phpext\Php\Iconv;

use Phpext\AbstractCallable;

/**
 * iconv est un utilitaire permettant de modifier l'encodage des fichiers texte
 * L'extension iconv convertit des fichiers entre divers jeux de caractères
 * 
 * @see https://www.php.net/manual/fr/book.iconv.php
 */
/*
 *  iconv_get_encoding — Lit le jeu de caractères courant
    iconv_mime_decode_headers — Décode des en-têtes MIME multiples
    iconv_mime_decode — Décode un champ d’en‐tête MIME
    iconv_mime_encode — Construit un en-tête MIME avec les champs field_name et field_value
    iconv_set_encoding — Modifie le jeu courant de caractères d'encodage
    iconv_strlen — Retourne le nombre de caractères d'une chaîne
    iconv_strpos — Trouve la position de la première occurrence d'une chaîne dans une autre
    iconv_strrpos — Trouve la position de la dernière occurrence d'un élément dans une chaîne
    iconv_substr — Coupe une partie de chaîne
    iconv — Convertit une chaîne dans un jeu de caractères
    ob_iconv_handler — Gestionnaire de sortie pour maîtriser le jeu de caractères de sortie
 */
class IconvExt extends AbstractCallable
{
    protected const EXT = 'iconv';

    public function call(): array
    {
        return [
            'iconv_get_encoding' => $this->encode(),
            'iconv-strlen' => $this->length(),
            'iconv' => $this->iconv(),
            'buffer' => $this->buffer(),
            'convert' => $this->convert(),
        ];
    }

    public function encode(): string
    {
        $encoding = iconv_get_encoding('all');

        //  ISO 8859-1 is a single-byte encoding that can represent the first 256 Unicode characters
        ini_set('default_charset', 'ISO-8859-1');
        $encoding = iconv_get_encoding('all');

        ini_set('default_charset', 'UTF-8');

        return join(',', $encoding);
    }

    public function length(): string
    {
        //$error = error_reporting(E_ALL & ~E_NOTICE);        
        ini_set('default_charset', 'UTF-8');
        ini_set('internal_encoding', 'ISO-8859-1');

        $str = "I?t?rn?ti?n\xe9?liz?ti?n"; // wrong char
        $e = error_reporting(E_ALL & ~E_NOTICE);
        iconv_strlen($str); //NULL
        
        $a = "0xc4 0x83"; //ă
        $str = "ѣ𝔠ծềſģȟᎥ𝒋ǩľḿꞑȯ𝘱𝑞𝗋𝘴ȶ𝞄^&$a";

        $ret = "length: " . iconv_strlen($str) 
            .  " pos: " . iconv_strrpos($str, "ȯ", ini_get('iconv.internal_encoding'));
        error_reporting($e);
        
        return $ret;
    }

    public function buffer(): string
    {
        //iconv_set_encoding("internal_encoding", "UTF-8");
        //iconv_set_encoding("output_encoding", "ISO-8859-1");

        ob_start("ob_iconv_handler"); // start output buffering
        echo "𝒋ǩľḿꞑȯ𝘱𝑞𝗋";
        $ob = ob_get_clean();

        return $ob;
    }

    public function iconv(): string
    {
        setlocale(LC_CTYPE, 'POSIX'); //translit depends of local
        $iconv = "POSIX:" . iconv('UTF-8', 'ASCII//TRANSLIT', "Žluťoučký");

        setlocale(LC_CTYPE, 'cs_CZ');
        $iconv .= " - CZ TRANS:" . iconv('UTF-8', 'ASCII//TRANSLIT', "Žluťoučký");

        setlocale(LC_CTYPE, 'en_EN');
        $iconv .= " - EN IGNORE:" . iconv('UTF-8', 'ASCII//IGNORE', "Žluťoučký");

        $iconv .= " - UTF8:" . iconv('UTF-8', 'UTF-8//IGNORE', "Žluťoučký");

        return $iconv;
    }

    public function convert(): string
    {
        return "bin(ă):" . bin2hex("ă")
            . " - hex(c483):" . hex2bin("c483") 
            . " - \\xc4\\x83: \xc4\x83"
            . " - bin(Žlť)" . bin2hex("Ž l ť")
        ;
    }
}
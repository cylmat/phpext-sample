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
    public function call(): array
    {
        return [];
    }
}
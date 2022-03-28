<?php

declare(strict_types=1);

namespace Phpext\Php\Intl;

use Phpext\AbstractCallable;

/**
 * L'extension d'Internationalization (qui est aussi appelée Intl) est une interface pour la bibliothèque » ICU
 * International Components for Unicode
 * Set of C/C++ and Java libraries that provides globalization support for the internationalization of software systems.
 * 
 * @see https://www.php.net/manual/fr/book.intl.php
 * @see https://icu.unicode.org
 */
/*
Collator: Fournit des outils de comparaisons de chaînes, avec le support des conventions locales pour les tris. 
NumberFormatter: formater les nombres, les montants de devises et les pourcentages, en fonctions des conventions locales
Locale: utilisées pour interagir avec les identifiants locaux : pour vérifier qu'un identifiant est bien formé, valide, etc
Normalizer: transformation de caractères et de séquences de caractères dans une représentation formelle
MessageFormatter: produire des messages concaténés, et indépendants de la langue
IntlCalendar: active l'analyse et le formatage de dates, basé sur des chaînes modèles, ou des règles
IntlGregorianCalendar: 
IntlTimeZone: 
IntlDateFormatter: 
ResourceBundle: permet l'accès aux fichiers de données de ICU, pour stocker les données localisées
Spoofchecker: vérifier si une chaîne individuelle est susceptible d'être une tentative à tromper le lecteur
Transliterator: translittération des chaînes de caractères
IntlBreakIterator: Base class for ICU object that exposes methods for locating boundaries in text (e.g. word or sentence boundaries)
IntlRuleBasedBreakIterator: encapsulates ICU break iterators whose behavior is specified using a set of rules
IntlCodePointBreakIterator: identifies the boundaries between UTF-8 code points
IntlPartsIterator: provide, as a convenience, the text fragments comprehended between two successive boundaries
UConverter: 
Fonctions Grapheme: Extrait un groupe de graphème d'une chaîne UTF-8
Fonctions IDN: Internationalized domain name
IntlChar: access information about Unicode characters
IntlException, IntlIterator, intl_error_name, intl_get_error_code, intl_get_error_message, intl_is_failure 
 */
class Intl extends AbstractCallable
{
    public function call(): array
    {
        return [
            $this->printed()
        ];
    }

    public function printed(): array
    {
        return [
            sprintf('%x', \IntlChar::CODEPOINT_MAX),
            sprintf('%x', \IntlChar::charName('@')),
            sprintf('%x', \IntlChar::ispunct('!')),
        ];
    }
}
<?php

namespace Innova\SelfBundle\Command;
/**
 * Static function for fixtures command. EV #185
 *
*/
class StaticCommand
{

    /**
     * textSource function
     *
     */
    public static function textSource($textSource)
    {

        // Règles :
        // *** pour un texte italique
        // $$$ pour un texte souligné
        // ### pour un texte gras
        // @@@ pour aller à la ligne
        //
        //
        // For more explications : http://www.php.net/manual/fr/reference.pcre.pattern.modifiers.php
        $textDisplay = preg_replace('/\*{3}(.*?)\*{3}/s', '<i>$1</i>', $textSource); // Texte italique

        $textDisplay = preg_replace('/\${3}(.*?)\${3}/s', '<u>$1</u>', $textDisplay); // Texte souligné

        $textDisplay = preg_replace('/\#{3}(.*?)\#{3}/s', '<b>$1</b>', $textDisplay); // Texte en gras

        $textDisplay = str_replace('@@@', '<br>', $textDisplay); // Saut de ligne

        return $textDisplay;
    }

}

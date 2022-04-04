<?php

namespace WebtoonLike\Site\features;

use function WebtoonLike\Site\getSettings;

class translationHandler
{

    private static $googleApiKey = getSettings()['googleTranslateApi'];

    /**
     * Retourne l'URL contenant la clef d'API, la query (texte a traduire), 
     * la source (langue du texte) et la target (langue que l'on traduit vers).
     * Cette fonction suppose qu'une clef d'API existe src/setting.php
     *
     * @return string
     */
    private function buildRequest($query, $target, $source=''): string {
        $request = 'https://www.googleapis.com/language/translate/v2?key=' . self::$googleApiKey . '&q=' . rawurlencode($query) . '&source=' . $source . '&target=' . $target;
        return $request;
    }

    /**
     * Retourne le text traduit vers une langue $target, l'API essaie de la deduire si non specificée.
     * Cette fonction utilise la methode buildRequest pour construire l'URL. 
     *
     * @todo : utiliser curl pour appeler l'API
     * @todo : Gerer les exceptions.
     * @return string
     */
    public static function translate($source, $target, $query): string {
        $request = self::buildRequest($source, $target, $query);
        # use curl from here.
        # ...
        $response = '';
        return json_decode($response, true)['data']['translations'][0]['translatedText'];
    }
    
}
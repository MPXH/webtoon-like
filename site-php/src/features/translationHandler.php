<?php

namespace WebtoonLike\Site\features;

use JetBrains\PhpStorm\Pure;
use function WebtoonLike\Site\getSettings;

class translationHandler
{

    /**
     * Retourne la requête construite
     *
     * @param string $query Texte à traduire
     * @param string $target Langue souhaiter
     * @param string $source Langue du texte à traduire
     * @return string
     */
    #[Pure] private static function buildRequest(string $query, string $target, string $source): string {
        $uri = 'https://www.googleapis.com/language/translate/v2';
        $options = [
            'key' => getSettings()['googleTranslateApi'],
            'q' => rawurlencode($query),
            'source' => $source,
            'target' => $target
        ];
        $req = $uri . '?';
        foreach ($options as $key => $value) {
            $req .= $key . '=' . $value . '&';
        }
        return substr($req, 0, -1);
    }

    /**
     * Retourne le texte traduit vers la langue souhaitée
     *
     * @todo : utiliser curl pour appeler l'API
     * @todo : Gérer les exceptions.
     * @param string $source Langue du texte à traduire
     * @param string $target Langue souhaiter
     * @param string $query Texte à traduire
     * @return string
     */
    public static function translate(string $source, string $target, string $query): string {
        $request = self::buildRequest($source, $target, $query);
        # use curl from here.
        # ...
        $response = '';
        return json_decode($response, true)['data']['translations'][0]['translatedText'];
    }
    
}
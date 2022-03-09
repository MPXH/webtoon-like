<?php
namespace WebtoonLike\Api\Utils;

class RegexUtils {

    /**
     * Renvoie les paramètres de l'url
     * @param string $basePath Chemin de base de l'url
     * @param string $test Url à testée
     */
    public static function getRouteParams(string $basePath, string $test): string | null
    {
        $formattedBasePath = self::formatPath($basePath);
        $regex = "/^\/?{$formattedBasePath}(?:\/([a-zA-Z0-9]+(?:[_\-][a-zA-Z0-9]+)*))?$/";
        preg_match($regex, $test, $matches);

        var_dump($matches);

        return sizeof($matches) > 0 ? $matches[1] : null;
    }

    /**
     * Formate une url pour être utilisée dans une expression régulière
     * @param string $path Url à traité
     * @return string Url formatée
     */
    private static function formatPath(string $path): string {
        return str_replace('/', '\\/', $path);
    }

    /**
     * Nettoie une url
     *
     * @param string $url
     * @return string le path nettoyé
     */
    public static function clearUrl(string $url): string {
        preg_match(
            '/^(?:\/src\/index\.php|\/index\.php|\/src|)?((?:\/[a-zA-Z0-9\-]+)*)$/',
            $url,
            $matches,
            PREG_OFFSET_CAPTURE,
            0
        );

        var_dump($url);

        return $matches ? $matches[1][0] : '';
    }
}
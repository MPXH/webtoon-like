<?php

namespace WebtoonLike\Site\utils;

class UriUtils
{
    private string $pageType;

    /** @var array<string, mixed> Liste des options */
    private array $options = [];

    public function __construct() {
        $this->analyseUri();
    }

    /**
     * Initialise les valeurs obtenables à partir de l'URI.
     *
     * @return void
     */
    private function analyseUri(): void {
        $re = '/^(\/(?:home|webtoons|index\.php|import|proposition|report|webtoon|error)?)(?:[\?\/]([\w\-\/=&]*))?$/';
        preg_match_all($re, $_SERVER['REQUEST_URI'], $matches);
        [$_, $pageType, $rawOptions] = $matches;    // Répartition du résultat

        // Vérification de l'existence du résultat
        if ($_ === []) {
            $this->pageType = 'error';
            $this->options['code'] = 404;
            $this->options['message'] = 'La page que vous essayez d\'obtenir n\'existe pas...';
            return;
        }

        // Obtention du type de page
        $this->pageType = match ($pageType[0]) {
            '/', '/home', '/webtoons', '/index.php' => 'home',
            default => substr($pageType[0], 1),
        };


        // Obtention d'un tableau des paramètres
        if ($rawOptions[0] !== '') {
            $options = mb_split('&', $rawOptions[0]);
            foreach ($options as $option) {
                [$key, $value] = mb_split('=', $option);
                $this->options[$key] = $value;
            }
        }
    }


    /**
     * Obtention du type de la page
     *
     * @return string
     */
    public function getPageType(): string {
        return $this->pageType;
    }

    /**
     * Obtention des paramètres sous forme de tableau
     *
     * @todo : Add GET / POST parameters
     * @return array<string, mixed>
     */
    public function getArrayOptions(): array {
        return $this->options;
    }
}
<?php

namespace WebtoonLike\Site;

function getSettings(): array{
    return [
        'googleTranslateApi' => '',
        'preTranslateTo' => [
            'fr',
            'en'
        ],
        'webtoonsImagesBaseFolder' => dirname(__DIR__) . '/assets/webtoons-imgs',
        'database' => [
            'host' => 'localhost',
            'username' => 'root',       // TODO: Replace root in production
            'password' => null,
            'dbName' => 'webtoonLike',
            'port' => null,
            'socket' => null
        ]
    ];
}

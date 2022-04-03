<?php

namespace WebtoonLike\Site;

const SETTINGS = [
    'googleTranslateApi' => '',
    'preTranslateTo' => [
        'fr',
        'en'
    ],
    'database' => [
        'host' => 'localhost',
        'username' => 'root',       // TODO: Replace root in production
        'password' => null,
        'dbName' => 'webtoonLike',
        'port' => null,
        'socket' => null
    ]
];

function getSettings(): array {
    return SETTINGS;
}

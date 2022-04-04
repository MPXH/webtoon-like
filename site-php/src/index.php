<?php

namespace WebtoonLike\Site;

require_once __DIR__ . '/../vendor/autoload.php';

use WebtoonLike\Site\utils\PageUtils;

$p = new PageUtils();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A5353">

    <title><?= $p->getPageTitle() ?></title>

    <?= $p->getStylesheets() ?>
    <?= $p->getScripts() ?>
</head>
<body>

<header>
    <?= $p->getLogo() ?>
    <fieldset>
        <label for="search">Rechercher</label>
        <input type="search" name="search" id="search" placeholder="Rechercher" data-searchbar>
        <div class="search-result" data-search-result></div>
    </fieldset>
    <nav class="icons">
        <ul>
            <?= $p->getNaviguation() ?>
        </ul>
    </nav>
</header>

<?php $p->router() ?>

<footer>
    <!-- Todo: Compléter -->
    <p>
        Projet universitaire par
        <a href="https://github.com/remib18">Rémi Bernard</a>,
        <a href="https://github.com/onetrickwolfy">Gabriel Berthel</a>,
        <a href="https://github.com/MPXH">Hugo Remy</a>,
        <a href="https://github.com/YacineHB">Yacine Hbada</a>.
    </p>
</footer>

<template data-item-result-template>
    <a href="" class="webtoon">
        <img src="https://via.placeholder.com/150x200" alt="cover">
        <span class="webtoon-title">Title</span>
    </a>
</template>

</body>
</html>

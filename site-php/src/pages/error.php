<style>
    .message {
        padding-inline: 1rem;
    }

    .button {
        width: 8rem;
        text-decoration: none;
        margin-block-start: 2rem !important;
        margin-inline: 1rem !important;
        text-align: center;
    }
</style>

<section aria-describedby="#s1-title" id="app">
    <h2 id="s1-title">Oups, une erreur est survenue !</h2>
    <p class="message"><?= urldecode($_GET['msg']) ?? 'Une erreur est survenue...' ?></p>
    <a href="/" class="button">Retour à l'accueil</a>
</section>
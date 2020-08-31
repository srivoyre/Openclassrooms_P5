<?php $this->title = "Erreur 500: erreur interne du serveur"; ?>

<a type="button" class="btn btn-light mb-5" href="index.php"><< Retour à l'accueil</a>

<h1>
    <?= filter_var($this->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
</h1>

<p>
    Oups ! Une erreur est survenue, veuillez rechargez la page ou revenir à l'accueil.
</p>

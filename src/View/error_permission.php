<?php $this->title = "Privilèges insuffisants"; ?>

<a type="button" class="btn btn-light" href="index.php"><< Retour à l'accueil</a>

<h1>
    <?= filter_var($this->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
</h1>
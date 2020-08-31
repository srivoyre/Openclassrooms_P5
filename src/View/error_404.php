<?php $this->title = "Erreur 404 : Page non trouvée"; ?>

<a type="button" class="btn btn-light mb-5" href="index.php"><< Retour à l'accueil</a>

<h1>
    <?= filter_var($this->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;?>
</h1>
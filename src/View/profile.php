<?php $this->title = 'Mon profil'; ?>


<div class="row">
    <div class="col-12">
        <h1><?= filter_var($user->getPseudo()); ?></h1>
        <p>Membre depuis le <?= filter_var($user->getCreatedAt()); ?></p>

        <div id="jokes-container" class="row">
            <script type="text/javascript">
                savedJokesArray = <?php echo json_encode($savedJokesArray); ?>;
            </script>
            <?php
            foreach ($savedJokesArray as $savedJoke) {
            ?>
            <script type="text/javascript">
                specifiedJoke(<?= $savedJoke; ?>);
            </script>
                <?php
            }
            ?>
        </div>

        <form method="post" action="index.php?route=updateEmail">
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="email">E-mail :</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 pb-2">
                        <input class="form-control" type="email" id="email" name="email" aria-label="E-mail" value="<?= filter_var($user->getEmail(), FILTER_SANITIZE_EMAIL); ?>" required aria-required="true">
                        <br />
                        <span class="alert-danger">
                            <?= isset($errors['email']) ? filter_var($errors['email'], FILTER_SANITIZE_STRING) : ''; ?>
                        </span>
                    </div>
                    <div class="col-12 col-md-4 pb-2">
                        <input class="btn btn-primary" type="submit" value="Mettre à jour mon e-mail" id="submitEmail" name="submitEmail">
                    </div>
                </div>

            </div>
        </form>

        <div class="row mt-5">
            <div class="col-6 col-md-3 text-center text-md-left">
                <a type="button" class="btn btn-outline-primary btn-block" href="index.php?route=updatePassword">Modifier mon mot de passe</a>
            </div>
            <div class="col-6 col-md-3 text-center text-md-left">
                <a type="button" class="btn btn-outline-danger btn-block" href="index.php?route=deleteAccount">Supprimer mon compte</a>
            </div>
        </div>
    </div>

</div>


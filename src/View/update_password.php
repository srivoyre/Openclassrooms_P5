<?php $this->title = 'Modifier mon mot de passe'; ?>

<div class="row my-2">
    <div class="col-12 mx-0 px-0">
        <a class="btn btn-light" href="index.php?route=profile">
            << Retour au profil
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h1>Modifier mon mot de passe</h1>

        <form method="post" action="index.php?route=updatePassword">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <label for="password">Mot de passe actuel</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <input class="form-control" type="password" id="password" name="password" aria-label="Ancien mot de passe" required aria-required="true">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="newPassword">Nouveau mot de passe</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 pb-2">
                        <input class="form-control" type="password" id="newPassword" name="newPassword" aria-label="Nouveau mot de passe" required aria-required="true">
                        <span class="alert-danger">
                            <?= isset($errors['password']) ? filter_var($errors['password'], FILTER_SANITIZE_STRING) : ''; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input class="btn btn-primary"  type="submit" value="Mettre à jour" id="submit" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>

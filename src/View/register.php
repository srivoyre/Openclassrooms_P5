<?php $this->title = "Inscription"; ?>

<div class="row mt-5">
    <div class="col-sm-2 col-lg-3 col-xl-4"></div>

    <div class="col-12 col-sm-8 col-lg-6 col-xl-4">

        <h1>
            Inscription
        </h1>

        <form method="post" action="index.php?route=register">
            <div class="form-group">
                <label for="pseudo">Pseudo*</label>
                <br />
                <input class="form-control" type="text" id="pseudo" name="pseudo" aria-label="Pseudo" required aria-required="true">
                <br />
                <span class="alert-danger">
                    <?= isset($errors['pseudo']) ? filter_var($errors['pseudo'], FILTER_SANITIZE_STRING) : ''; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail*</label>
                <br />
                <input class="form-control" type="email" id="email" name="email" aria-label="E-mail" aria-describedby="basic-addon1" required aria-required="true">
                <br />
                <span class="alert-danger">
                    <?= isset($errors['email']) ? filter_var($errors['email'], FILTER_SANITIZE_STRING) : ''; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe*</label><span class="small font-italic">(au moins 6 caractères)</span>
                <br />
                <input class="form-control" type="password" id="password" name="password" aria-label="Mot de passe" required aria-required="true">
                <br />
                <span class="alert-danger">
                    <?= isset($errors['password']) ? filter_var($errors['password'], FILTER_SANITIZE_STRING) : ''; ?>
                </span>
            </div>
            <input class="btn btn-primary" type="submit" value="Inscription" id="submit" name="submit">
        </form>

        <div class="row mt-5">
            <div class="col-6 text-center">
                <a type="button" class="btn btn-primary btn-block" href="index.php?route=login">
                    J'ai un compte !
                </a>
            </div>
            <div class="col-6 text-center">
                <a type="button" class="btn btn-info btn-block" href="index.php">
                    Aller à l'accueil
                </a>
            </div>
        </div>

    </div>

    <div class="col-sm-2 col-lg-3 col-xl-4"></div>

</div>

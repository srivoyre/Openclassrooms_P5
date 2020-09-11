<?php $this->title = 'Update my password'; ?>
<?php $this->h1 = $this->title; ?>

<div class="row">
    <div class="col-12">

        <form method="post" action="index.php?route=updatePassword">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <label for="password">Current password</label>
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
                        <label for="newPassword">New password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 pb-2">
                        <input class="form-control" type="password" id="newPassword" name="newPassword" aria-label="Nouveau mot de passe" required aria-required="true">
                        <span class="alert-danger">
                            <?= isset($errors['password']) ? filter_var($errors['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''; ?>
                        </span>
                        <div class="row my-2">
                            <div class="col-12">
                                <input class="btn btn-primary btn-block"  type="submit" value="Update" id="submit" name="submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row my-2">
    <div class="col-12 mx-0 px-0 my-3">
        <a class="btn btn-light" href="index.php?route=profile">
            << Back to profile
        </a>
    </div>
</div>
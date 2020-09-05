<?php $this->title = 'Profile'; ?>
<?php $this->h1 = 'Profile'; ?>

<div class="row">
    <div class="col-12">
        <h2><?= filter_var($user->getPseudo()); ?></h2>
        <p class="font-italic">Member since <?= filter_var($user->getCreatedAt()); ?></p>

        <div class="btn-group col-12 p-0" role="group">
            <div id="showJokes" type="button" class="btn btn-primary border border-light col-6 col-lg-4">Saved jokes</div>
            <div id="showUserInfo" type="button" class="btn btn-primary border border-light col-6 col-lg-4">Personal info</div>
        </div>

        <div class="row my-3">
            <div id="jokes-container" class="col-12 col-sm-10 col-md-8 d-none">
                <script type="text/javascript">
                    savedJokesArray = <?php echo json_encode($savedJokesArray); ?>;
                </script>
                <?php
                foreach ($savedJokesArray as $savedJoke) {
                    ?>
                    <div id="joke-container<?= $savedJoke; ?>" class="row border-bottom py-3">
                        <script type="text/javascript">
                            getSpecificJoke(<?= $savedJoke; ?>);
                        </script>
                        <div class="col-10">
                            <span id="joke<?= $savedJoke; ?>" class="align-left joke text-wrap"></span>
                        </div>
                        <div id="actions-container<?=$savedJoke;?>" class="col-2 actions-container text-left">
                            <a type="button"
                               id="saveJokeBtn<?= $savedJoke; ?>"
                               class="btn btn-outline-primary"
                               href="index.php?route=saveJoke&jokeApiId=<?= $savedJoke; ?>"
                               title="Add joke to favourites">
                                <i class="far fa-star"></i>
                            </a>
                            <a type="button"
                               id="removeSavedJokeBtn<?= $savedJoke; ?>"
                               class="btn"
                               href="index.php?route=removeJoke&jokeApiId=<?= $savedJoke; ?>"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="Remove joke from favourites">
                                <i id="saved-icon" class="fas fa-star text-warning"></i>
                            </a>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>

            <div id="user-info" class="col-12 d-none">
                <div class="col-12">
                    <form method="post" action="index.php?route=updateEmail">
                        <div class="form-group row">
                            <div class="col-12 col-md-10 col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="email">E-mail :</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 pb-2">
                                        <input class="form-control"
                                               type="email"
                                               id="email"
                                               name="email"
                                               aria-label="E-mail"
                                               value="<?= filter_var($user->getEmail(), FILTER_SANITIZE_EMAIL); ?>"
                                               aria-required="true"
                                               required>
                                        <br />
                                        <span class="alert-danger">
                                         <?= isset($errors['email']) ? filter_var($errors['email'], FILTER_SANITIZE_STRING) : ''; ?>
                                    </span>
                                        <input class="btn btn-primary" type="submit" value="Update email" id="submitEmail" name="submitEmail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5">
                        <div class="col-6 col-md-3 text-center text-md-left">
                            <a type="button" class="btn btn-outline-primary btn-block" href="index.php?route=updatePassword">Update my password</a>
                        </div>
                        <div class="col-6 col-md-3 text-center text-md-left">
                            <a type="button" class="btn btn-outline-danger btn-block" href="index.php?route=deleteAccount">Delete my account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
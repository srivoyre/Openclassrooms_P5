<?php
$this->title = 'Profile';
$this->h1 = $this->title;
?>

<div class="row">
    <div class="col-12">
        <h2><?= filter_var($user->getPseudo()); ?></h2>
        <p class="font-italic">Member since <?= filter_var($user->getCreatedAt()); ?></p>

        <div class="btn-group col-12 p-0" role="group">
            <div id="showJokes" type="button" class="btn btn-primary border border-light col-6 col-lg-4">Saved jokes</div>
            <div id="showUserInfo" type="button" class="btn btn-primary border border-light col-6 col-lg-4">Personal info</div>
        </div>
        <div class="row my-3">
            <div id="jokes-container" class="col-12 col-sm-10 p-3">
                <script type="text/javascript">
                    savedJokesArray = <?php echo json_encode($savedJokesArray); ?>;
                </script>
                <?php
                if ($savedJokesArray == null) {
                    ?>
                    <div class="row border-bottom py-3 ml-2">
                        <span class="font-weight-bold font-italic">
                            No saved jokes yet!
                        </span>
                    </div>
                    <?php
                }
                foreach ($savedJokesArray as $savedJoke) {
                    ?>
                    <div id="joke-container<?= $savedJoke; ?>" class="row border-bottom py-3">
                        <script type="text/javascript">
                            getJoke(false, <?= $savedJoke; ?>);
                        </script>
                        <div class="col-10">
                            <span id="joke<?= $savedJoke; ?>" class="align-left joke text-wrap"></span>
                        </div>
                        <div id="actions-container<?=$savedJoke;?>" class="col-2 actions-container text-left">
                            <a type="button"
                               id="removeSavedJokeBtn<?= $savedJoke; ?>"
                               class="btn removeSavedJoke"
                               title="Remove joke"
                               href="index.php?route=removeJoke&jokeApiId=<?= $savedJoke; ?>">
                                <i id="saved-icon<?= $savedJoke; ?>" class="fas fa-star p-2 text-warning action-icon"></i>
                                <i id="remove-icon<?= $savedJoke; ?>" class="fas fa-times p-2 text-danger action-icon d-none"></i>
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
                            <div class="col-12 col-md-10 col-lg-8 p-0">
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
                                               value="<?= isset($post) ? filter_var((string)$post->get('email')) : filter_var($user->getEmail(), FILTER_SANITIZE_EMAIL); ?>"
                                               aria-required="true"
                                               required>
                                        <br />
                                        <span class="alert-danger">
                                         <?= isset($errors['email']) ? filter_var($errors['email'], FILTER_SANITIZE_STRING) : ''; ?>
                                    </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 pb-2">
                                        <input class="btn btn-primary" type="submit" value="Update email" id="submitEmail" name="submitEmail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5">
                        <div class="col-6 col-md-3 text-center text-md-left p-1">
                            <a type="button" class="btn btn-outline-primary btn-block" href="index.php?route=updatePassword">Update password</a>
                        </div>
                        <div class="col-6 col-md-3 text-center text-md-left p-1">
                            <a type="button" class="btn btn-outline-danger btn-block" href="index.php?route=deleteAccount">Delete account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setUpProfilePage();
    let showUserInfo = <?php echo isset($showUserInfo) ? $showUserInfo : 0;?>;
    if (showUserInfo == true) {
        showElement(document.getElementById('user-info'));
        hideElement(document.getElementById('jokes-container'))
    }
</script>
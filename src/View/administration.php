<?php $this->title = 'Administration'; ?>
<?php $this->h1 = 'Administration'; ?>

<script type="text/javascript">
    showJokesInAdminSpace = true;
</script>

<section>

    <h2>Reported jokes</h2>

    <table class="table table-hover">

        <thead class="d-none d-lg-block">
            <tr class="d-flex justify-content-between">
                <th class="flex-fill" scope="col">Joke</th>
                <th class="text-right flex-fill" scope="col">Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        if ($flaggedJokes == null) {
            ?>
            <tr>
                <td colspan="2" class="text-center font-italic font-weight-bold">
                    No reported jokes yet!
                </td>
            </tr>
            <?php
        }
        foreach($flaggedJokes as $flaggedJoke)
        {
            ?>
            <tr id="jokes-container<?= $flaggedJoke->getJokeApiId(); ?>" class="d-flex flex-wrap justify-content-lg-between">
                <td id="joke-container<?= $flaggedJoke->getJokeApiId(); ?>" class="col-12 col-lg-10">
                    <script type="text/javascript">
                        specifiedJoke(<?= $flaggedJoke->getJokeApiId(); ?>);
                    </script>
                </td>
                <td id="actionsBtn<?= $flaggedJoke->getJokeApiId(); ?>" class="col-12 col-lg-2 text-lg-right">
                    <a type="button" class="btn btn-outline-primary mb-1 mx-1" href="index.php?route=unflagJoke&jokeId=<?= filter_var($flaggedJoke->getId(), FILTER_SANITIZE_NUMBER_INT); ?>">
                        Unflag
                    </a>
                    <a type="button" class="btn btn-outline-danger mb-1 mx-1" href="index.php?route=filterJoke&jokeId=<?= filter_var($flaggedJoke->getId(), FILTER_SANITIZE_NUMBER_INT); ?>">
                        Filter
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

</section>

<div class="my-5">
    <hr>
</div>

<section>

    <h2>Utilisateurs</h2>

    <table class="table table-hover">
        <thead class="d-none d-lg-block">
            <tr class="d-flex">
                <th class="col-lg-2" scope="col">Pseudo</th>
                <th class="col-lg-3" scope="col">Email</th>
                <th class="col-lg-2" scope="col">Date de création</th>
                <th class="col-lg-3" scope="col">Rôle</th>
                <th class="col-lg-2 text-right" scope="col">Actions</th>
            </tr>
        </thead>
        <?php
        if ($users == null) {
            ?>
            <tr>
                <td colspan="5" class="text-center font-italic font-weight-bold">
                    No users to manage yet!
                </td>
            </tr>
            <?php
        }
        foreach($users as $user)
        {
            ?>
            <tr class="d-flex flex-column flex-lg-row">
                <th class="d-flex justify-content-between col-12 col-lg-2" scope="row">
                    <div>
                        <?= filter_var($user->getPseudo(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                    </div>
                    <div class="d-lg-none d-xl-none font-weight-normal">
                        <?php
                        if(!$user->getIsAdmin())
                        {
                            ?>
                            <a type="button" class="btn btn-outline-danger" href="index.php?route=deleteUser&userId=<?= filter_var($user->getId(), FILTER_SANITIZE_NUMBER_INT); ?>">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <span class="font-italic">
                    Suppression impossible
                </span>
                            <?php
                        }
                        ?>
                    </div>
                </th>
                <td class=" col-12 col-lg-3">
                    <a href="mailto:<?= filter_var($user->getEmail(),FILTER_SANITIZE_EMAIL); ?>">
                        <?= filter_var($user->getEmail(),FILTER_SANITIZE_EMAIL); ?>
                    </a>
                </td>
                <td class=" col-12 col-lg-2">
                    <?= filter_var($user->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                </td>
                <td class=" col-12 col-lg-3">
                    <?= filter_var($user->getRole(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?> user
                </td>
                <td class="d-none d-lg-block col-lg-2 text-right">
                    <?php
                    if(!$user->getIsAdmin())
                    {
                        ?>
                        <a type="button" class="btn btn-outline-danger" href="index.php?route=deleteUser&userId=<?= filter_var($user->getId(), FILTER_SANITIZE_NUMBER_INT); ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span class="font-italic">
                        Suppression impossible
                    </span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

</section>

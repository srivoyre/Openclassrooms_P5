<?php $this->title = 'Administration'; ?>
<section>

    <h2>Reported jokes</h2>

    <table class="table table-hover table-responsive-lg">

        <thead>
        <tr>
            <th class="text-justify" scope="col">Joke</th>
            <th scope="col">Category</th>
            <th class="text-right" scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($flaggedJokes as $flaggedJoke)
        {
            ?>
            <tr>
                <th scope="row">
                    <script type="text/javascript">
                        specifiedJoke(<?= $flaggedJoke->getJokeApiId(); ?>);
                    </script>
                </th>
                <td class="text-break">
                   Category
                </td>
                <td class="d-flex flex-wrap justify-content-end">
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

    <table class="table table-hover table-responsive-lg">
        <thead>
        <th class="text-center" scope="col">Pseudo</th>
        <th scope="col">Email</th>
        <th scope="col">Date de création</th>
        <th scope="col">Rôle</th>
        <th class="text-right" scope="col">Actions</th>
        </thead>
        <?php
        foreach($users as $user)
        {
            ?>
            <tr>
                <th scope="row">
                    <?= filter_var($user->getPseudo(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                </th>
                <td>
                    <a href="mailto:<?= filter_var($user->getEmail(),FILTER_SANITIZE_EMAIL); ?>">
                        <?= filter_var($user->getEmail(),FILTER_SANITIZE_EMAIL); ?>
                    </a>
                </td>
                <td>
                    <?= filter_var($user->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                </td>
                <td>
                    <?= filter_var($user->getRole(), FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                </td>
                <td class="d-flex flex-wrap justify-content-end">
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

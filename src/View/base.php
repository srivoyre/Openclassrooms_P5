<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>
            <?= filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>
        </title>

        <link rel="canonical" href="onlineprojects.fr">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <meta name="description" content="Random Joke Generator">
        <meta name="author"     content="Sophie de Rivoyre">
        <meta name="copyright"  content="MIT">

        <meta property="og:type"        content="website">
        <meta property="og:title"       content="Random Joke Generator">
        <meta property="og:url"         content="randomjokegenerator.onlineprojects.fr">
        <meta property="og:description" content="Random Joke Generator">
        <meta property="og:image"       content="img/logo.png">

        <meta name="twitter:card"           content="summary">
        <meta name="twitter:title"          content="Random Joke Generator">
        <meta name="twitter:site"           content="randomjokegenerator.onlineprojects.fr">
        <meta name="twitter:description"    content="Random Joke Generator">
        <meta name="twitter:image"          content="img/logo.png">
        <meta name="twitter:creator"        content="@sophiederivoyre">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">

        <!--jQuery, Poppers.js, Bootstrap JS, then custom scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/65eb1404cc.js" crossorigin="anonymous"></script>
        <script src="../public/js/main.js"></script>
        <script src="../public/js/Joke.js"></script>
        <script src="../public/js/JokeApiXHR.js"></script>
    </head>

    <body>

        <header>

            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="index.php">Home</a>
                        <?php
                        if($this->session->get('loggedIn'))
                        {
                            if($this->session->get('user')->getIsAdmin()) {
                                ?>
                                <a class="nav-link" href="index.php?route=administration">Administration</a>
                                <?php
                            }
                            ?>
                            <a class="nav-link" href="index.php?route=profile">Profile</a>
                            <a class="nav-link" href="index.php?route=logout">Logout</a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="nav-link" href="index.php?route=register">Register</a>
                            <a class="nav-link" href="index.php?route=login">Login</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </header>

        <div class="row mt-3 position-relative">
            <div class="col-1 col-sm-2 col-md-3 col-lg-4"></div>
            <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                <div id="message" class="fadeOut position-absolute">
                    <?php
                    if ($this->session->get('info_message')) {
                        ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= filter_var($this->session->show('info_message'), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                    } elseif ($this->session->get('success_message')) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= filter_var($this->session->show('success_message'), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                    } elseif ($this->session->get('warning_message')) {
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= filter_var($this->session->show('warning_message'), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                    } elseif ($this->session->get('error_message')) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= filter_var($this->session->show('error_message'), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-1 col-sm-2 col-md-3 col-lg-4"></div>
        </div>

        <div class="row mt-3">
            <div class="col-1 col-lg-2"></div>
            <div class="col-10 col-lg-8">
                <h1>
                    <?= filter_var($h1, FILTER_SANITIZE_FULL_SPECIAL_CHARS); ?>
                </h1>
            </div>
            <div class="col-1 col-lg-2"></div>
        </div>

        <div id="content" class="row">
            <div class="col-1 col-lg-2"></div>
            <div class="col-10 col-lg-8">
                <?= filter_var($content); ?>
            </div>
            <div class="col-1 col-lg-2"></div>
        </div>

    </body>

</html>
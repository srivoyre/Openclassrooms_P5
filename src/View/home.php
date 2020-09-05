<?php $this->title = 'Home'; ?>

<div class="row mt-4">
    <div class="col-md-1 col-lg-2"></div>
    <div class="col-md-10 col-lg-8">
        <h1 class="text-center mb-5">
            Random joke generator
        </h1>
        <div class="row mb-5">
            <div class="col-1"></div>
            <div id="joke-container" class="col-10 text-center py-5 overflow-auto position-relative">
                <div id="actions-container" class="position-absolute">
                    <a type="button"
                       id="saveJokeBtn"
                       class="btn btn-outline-primary saveJokeBtn"
                       href="index.php?route=saveJoke&jokeApiId="
                       title="Add joke to favourites">
                        <i class="far fa-star"></i>
                    </a>
                    <a type="button"
                       id="removeSavedJokeBtn"
                       class="btn"
                       href="index.php?route=removeJoke&jokeApiId="
                       data-toggle="tooltip"
                       data-placement="top"
                       title="Remove joke from favourites">
                        <i id="saved-icon" class="fas fa-star text-warning"></i>
                    </a>
                    <a type="button"
                       id="flagJokeBtn"
                       class="btn btn-outline-danger"
                       href="index.php?route=flagJoke&jokeApiId=">
                        <i class="far fa-flag"></i>
                    </a>
                </div>
                <span id="joke" class="align-left joke"></span>
            </div>
            <div class="col-1"></div>
        </div>

        <div class="row">
            <div class="col-3 col-sm-4 col-lg-5"></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center">
                <button id="newJoke" class="btn btn-primary btn-block" type="button" name="newJoke" onclick="getRandomJoke();">
                    New joke
                </button>
            </div>
            <div class="col-3 col-sm-4 col-lg-5"></div>
        </div>
    </div>
    <div class="col-md-1 col-lg-2"></div>
</div>

<script type="text/javascript">
    filteredJokesArray = <?php echo json_encode($filteredJokes); ?>;
    savedJokesArray =
    <?php
    if ($this->session->get('loggedIn')) {
        echo json_encode($savedJokesArray);
    } else {
        echo '[]';
    }
    ?>;
</script>

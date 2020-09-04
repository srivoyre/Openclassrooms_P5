<?php $this->title = "Accueil"; ?>
<script type="text/javascript">
    filteredJokesArray = <?php echo json_encode($filteredJokes); ?>;
    savedJokesArray = <?php echo json_encode($savedJokesArray); ?>;
</script>

<div class="row mt-4">
    <div class="col-md-1 col-lg-2"></div>
    <div class="col-md-10 col-lg-8">
        <h1 class="text-center mb-5">
            Random joke generator
        </h1>
        <div class="row mb-5">
            <div class="col-1"></div>
            <div id="joke-container" class="col-10 text-center py-5">
                <!--<script type="text/javascript">

                </script>-->
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row">
            <div class="col-3 col-sm-4 col-lg-5"></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center">
                <button id="newJoke" class="btn btn-primary btn-block" type="button" name="newJoke" onclick="randomJoke();">
                    New joke
                </button>
            </div>
            <div class="col-3 col-sm-4 col-lg-5"></div>
        </div>
    </div>
    <div class="col-md-1 col-lg-2"></div>
</div>

<?php $this->title = "Accueil"; ?>
<?php $this->script = "src=\"../public/js/main.js\""; ?>

<div class="row mt-4">
    <div class="col-md-1 col-lg-2"></div>
    <div class="col-md-10 col-lg-8">
        <h1 class="text-center mb-5">
            Random joke generator
        </h1>
        <div class="row mb-5">
            <div class="col-1"></div>
            <div id="joke-container" class="col-10 text-center py-5">
                <!--<i class="far fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-flag"></i>
                <i class="fas fa-flag"></i>-->
                <span id="joke" class="align-middle"></span>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row">
            <div class="col-3 col-sm-4 col-lg-5"></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center">
                <button id="newJoke" class="btn btn-primary btn-block" type="button" name="newJoke" onclick="test();">
                    New joke
                </button>
            </div>
            <div class="col-3 col-sm-4 col-lg-5"></div>
        </div>
    </div>
    <div class="col-md-1 col-lg-2"></div>
</div>

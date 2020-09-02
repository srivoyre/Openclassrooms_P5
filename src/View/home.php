<?php $this->title = "Accueil"; ?>
<?php $this->script = "src=\"../public/js/main.js\""; ?>

<div class="row mt-4">
    <div class="col-md-1 col-lg-2"></div>
    <div class="col-md-10 col-lg-8">
        <h1>
            Accueil
        </h1>
        <div class="row">
            <div  id="joke-container" class="row text-center" style="height: 200px;display: table;">
                <span id="joke" class="align-middle" style="display: table-cell;"></span>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-3 text-center">
                    <button id="newJoke" class="btn btn-primary" type="button" name="newJoke" onclick="test();">
                        New joke
                    </button>
                </div>
                <div class="col-3 text-center">
                    <button id="saveJoke" class="btn btn-primary" type="button" name="saveJoke" onclick="">
                        Save
                    </button>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
    <div class="col-md-1 col-lg-2"></div>
</div>

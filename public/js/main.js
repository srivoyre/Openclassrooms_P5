/*************************************
 * variables declaration
 ************************************/
let savedJokesArray;

/*************************************
 * standard functions
 ************************************/
function hideElement(element) {
    element.classList.add('d-none');
}
function showElement(element) {
    element.classList.remove('d-none');
}

// Hides the joke container before a joke is returned on home page
document.addEventListener('DOMContentLoaded',(event) =>{
    if (document.getElementById('joke')
        && document.getElementById('joke').innerHTML === '') {
        hideElement(document.getElementById('joke-container'));
    }
})
/****************************************
 * App features
 ****************************************/
function setDynamicApiId(elementId, jokeId) {
    let url = new URL(document.getElementById(elementId).getAttribute('href'), 'http://localhost:8080/projects/OC_P5/public/');
    let search_params = url.searchParams;
    search_params.set('jokeApiId', jokeId);
    url.search = search_params.toString();
    let new_url = url.toString();
    document.getElementById(elementId).setAttribute('href', new_url);
}

function createJokeContainer(joke) {
    const jokeContent = () => {
        if (joke.type == "single") {
            return joke.joke;
         } else {
            return joke.setup + '<br /> <br />' + joke.delivery;
         }
    }
    let containerTemplate = document.createElement('div');
    containerTemplate.id = 'joke-container'+joke.id;
    containerTemplate.classList.add('row', 'joke-container');
    containerTemplate.innerHTML =
        '<a type="button" id="saveJokeBtn'
        + joke.id
        + '" class="btn btn-outline-primary" href="index.php?route=saveJoke&jokeApiId='
        + joke.id
        + '" title="Add joke to favourites">\n'
        + '<i class="far fa-star"></i>\n'
        + '</a>\n'
        + '<a type="button" id="removeSavedJokeBtn'
        + joke.id
        + '" class="btn" href="index.php?route=removeJoke&jokeApiId='
        + joke.id
        + '" data-toggle="tooltip" data-placement="top" title="Remove joke from favourites">\n'
        +'<i id="saved-icon" class="fas fa-star text-warning"></i>\n'
        +'</a>\n'
        +'\n'
        +'<a type="button" id="flagJokeBtn'
        + joke.id
        + '" class="btn btn-outline-danger" href="index.php?route=flagJoke&jokeApiId='
        + joke.id
        + '">\n'
        +'<i class="far fa-flag"></i>\n'
        +'</a>\n'
        +'\n'
        +'<a type="button" id="unflagJokeBtn'
        + joke.id
        +'" class="btn" href="index.php?route=flagJoke&jokeApiId='
        + joke.id
        + '">\n'
        +'<i class="fas fa-flag text-danger"></i>\n'
        +'</a>\n'
        +'\n'
        +'<span id="joke" class="align-middle joke">\n'
        + jokeContent()
        +'\n </span>';

    return containerTemplate;
}

function manageActionButtons(jokeId) {
    let saveBtn = document.getElementById('saveJokeBtn'+jokeId);
    let unsaveBtn = document.getElementById('removeSavedJokeBtn'+jokeId);
    let flagBtn = document.getElementById('flagJokeBtn'+jokeId);
    let unflagBtn = document.getElementById('unflagJokeBtn'+jokeId);

    if(savedJokesArray.indexOf(jokeId.toString()) !== -1) {
        hideElement(saveBtn);
        showElement(unsaveBtn);
    } else {
        hideElement(unsaveBtn);
        showElement(saveBtn);
    }
}

const processUniqueResult = function (result) {
    let jokeContainer = document.getElementById('joke-container');
    jokeContainer.innerHTML = '';

    let joke = new Joke(JSON.parse(result));
    jokeContainer.appendChild(createJokeContainer(joke));
    manageActionButtons(joke.id);
    // processing results
    /*if (joke.type == "single") {
        document.getElementById('joke').innerHTML = joke.joke;
    } else {
        document.getElementById('joke').innerHTML = joke.setup + '<br /> <br />' + joke.delivery;
    }
    console.log(savedJokesArray);
    console.log(savedJokesArray.indexOf(joke.id.toString()));
    if(savedJokesArray.indexOf(joke.id.toString()) !== -1) {
        hideElement(document.getElementById('saveJokeBtn'));
        showElement(document.getElementById('saved-icon'));
    } else {
        hideElement(document.getElementById('saved-icon'));
        showElement(document.getElementById('saveJokeBtn'));
    }*/
    /*
    setDynamicApiId('saveJokeBtn', joke.id);
    setDynamicApiId('flagJokeBtn', joke.id);
    setDynamicApiId('removeSavedJokeBtn', joke.id);*/
    showElement(document.getElementById('joke-container'));
}

const processMultipleResults = function (result) {
    let joke = new Joke(JSON.parse(result));
    let jokesContainer = document.getElementById('jokes-container');
    jokesContainer.appendChild(createJokeContainer(joke));
    manageActionButtons(joke.id)
}
/****************************************
 * functions called by user interaction
 ****************************************/
function randomJoke() {
    new XHRRequest(processUniqueResult, '');
}
function specifiedJoke(jokeApiId) {
    new XHRRequest(processMultipleResults, jokeApiId.toString());
}
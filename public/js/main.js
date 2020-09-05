/*************************************
 * variables declaration
 ************************************/
let savedJokesArray;
let filteredJokesArray;

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
document.addEventListener('DOMContentLoaded',() => {
    if (document.getElementById('joke-container')
        && document.getElementById('joke-container').innerHTML === '') {
        hideElement(document.getElementById('joke-container'));
    }
    let newRandomJokeBtn = document.getElementById('newRandomJoke');
    if (newRandomJokeBtn !== null) {
        newRandomJokeBtn.addEventListener('click', getRandomJoke, false);
    }
})

/****************************************
* App logic
****************************************/
const processRandomResult = function (result) {
    let joke = new Joke(JSON.parse(result), true);
    if (filteredJokesArray !== null
        && filteredJokesArray.indexOf(joke.id.toString()) !== -1) {
        getRandomJoke();
    } else {
        joke.createJokeContent();
        manageActionButtons('');
    }
}

const processSpecificResult = function (result) {
    let joke = new Joke(JSON.parse(result), false);
    joke.createJokeContent();
    manageActionButtons(joke.id);
}

function manageActionButtons(btnId) {
    let saveBtn = document.getElementById('saveJokeBtn' + btnId);
    let unsaveBtn = document.getElementById('removeSavedJokeBtn'+ btnId);
    if( savedJokesArray !== null
        && savedJokesArray.indexOf(btnId.toString()) !== -1
    ) {
        hideElement(saveBtn);
        showElement(unsaveBtn);
    } else {
        hideElement(unsaveBtn);
        showElement(saveBtn);
    }
}

/****************************************
 * functions called by user interaction
 ****************************************/
function getRandomJoke() {
    new JokeApiXHR(processRandomResult, '');
}
function getSpecificJoke(jokeApiId) {
    new JokeApiXHR(processSpecificResult, jokeApiId.toString());
}

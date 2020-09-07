/*************************************
 * variables declaration
 ************************************/
let savedJokesArray;
let filteredJokesArray;
/*************************************
 * standard functions
 ************************************/
function hideElement(element) {
    if (!element.classList.contains('d-none')) {
        element.classList.add('d-none');
    }
}
function showElement(element) {
    if (element.classList.contains('d-none')) {
        element.classList.remove('d-none');
    }
}

document.addEventListener('DOMContentLoaded',() => {
    setUpHomePage();
    setUpProfilePage();

    document.getElementById('saved-icon').addEventListener('mouseover', () => {
        hideElement(document.getElementById('saved-icon'));
        showElement(document.getElementById('remove-icon'));
    });

    document.getElementById('remove-icon').addEventListener('mouseout', () => {
        hideElement(document.getElementById('remove-icon'));
        showElement(document.getElementById('saved-icon'));
    });
});

function setUpHomePage() {
    if (document.getElementById('joke-container')
        && document.getElementById('joke').innerHTML === '') {
        hideElement(document.getElementById('joke-container'));
    }
    let newRandomJokeBtn = document.getElementById('newRandomJoke');
    if (newRandomJokeBtn !== null) {
        newRandomJokeBtn.addEventListener('click', getRandomJoke, false);
    }
}

function setUpProfilePage() {
    let jokesContainer = document.getElementById('jokes-container');
    let userInfo = document.getElementById('user-info');
    document.getElementById('showJokes').addEventListener('click', () => {
        showElement(jokesContainer);
        hideElement(userInfo);
    }, false);

    document.getElementById('showUserInfo').addEventListener('click', () => {
        showElement(userInfo);
        hideElement(jokesContainer);
    }, false);
}
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
    showElement(document.getElementById('joke-container'));
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

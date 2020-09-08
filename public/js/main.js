/*************************************
 * variables declaration
 ************************************/
let savedJokesArray;
let filteredJokesArray;
let saveBtn;
let unsaveBtn;
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
/****************************************
 * App functions
 ****************************************/
document.addEventListener('DOMContentLoaded',() => {
    setUpHomePage();
    setUpProfilePage();
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

    let jokesSpan = document.getElementsByClassName('joke');
    jokesSpan.forEach(function (item) {
        if (item.innerHTML === '') {
            item.innerHTML = '<span class="font-italic smaller">Sorry, joke not available at the moment. Come back in a few minutes!.</span>';
        }
    });
}
const processResult = function (result, random) {
    let joke = new Joke(JSON.parse(result), random);
    if (random === true
        && filteredJokesArray !== null
        && filteredJokesArray.indexOf(joke.id.toString()) !== -1
    ) {
        getRandomJoke();
    } else {
        joke.createJokeContent();
    }
    if (random === true) {
        manageActionButtons(
            document.getElementById('saveJokeBtn'),
            document.getElementById('removeSavedJokeBtn'),
            joke.id);
        showElement(document.getElementById('joke-container'));
    } else {
        manageActionButtons(
            document.getElementById('saveJokeBtn' + joke.id),
            document.getElementById('removeSavedJokeBtn' + joke.id),
            joke.id
        );
    }
}

function manageActionButtons(saveBtn, unsaveBtn, jokeId) {
    if( savedJokesArray !== null
        && savedJokesArray.indexOf(jokeId.toString()) === -1
    ) {
        hideElement(unsaveBtn);
        showElement(saveBtn);
    } else {
        hideElement(saveBtn);
        showElement(unsaveBtn);
    }
}
/****************************************
 * function called by user interaction
 ****************************************/
function getRandomJoke() {
    new JokeApiXHR(processResult, true, ''); //28
}
function getSpecificJoke(jokeApiId) {
    new JokeApiXHR(processResult, false, jokeApiId.toString());
}

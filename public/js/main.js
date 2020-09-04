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

const processUniqueResult = function (result) {
    let joke = new Joke(JSON.parse(result));
    console.log(joke.id);
    // processing results
    if (joke.type == "single") {
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
    }

    setDynamicApiId('saveJokeBtn', joke.id);
    setDynamicApiId('flagJokeBtn', joke.id);
    showElement(document.getElementById('joke-container'));
}

const processMultipleResults = function (result) {
    let joke = new Joke(JSON.parse(result));
    let jokesContainer = document.getElementById('jokes-container');
    let newJokeContainer = document.createElement('div');
    newJokeContainer.id = 'joke-container'+joke.id;
    newJokeContainer.classList.add('row', 'joke-container');
    let newJokeElement = document.createElement('span');
    newJokeElement.id = 'joke'+joke.id;
    newJokeElement.classList.add('joke', 'align-middle');
    newJokeContainer.appendChild(newJokeElement);
    jokesContainer.appendChild(newJokeContainer);

    if (joke.type == "single") {
        document.getElementById('joke'+joke.id).innerHTML = joke.joke;
    } else {
        document.getElementById('joke'+joke.id).innerHTML = joke.setup + '<br /> <br />' + joke.delivery;
    }
}
/****************************************
 * functions called by user interaction
 ****************************************/
function randomJoke() {
    new XHRRequest(processUniqueResult, '99');
}
function specifiedJoke(jokeApiId) {
    new XHRRequest(processMultipleResults, jokeApiId.toString());
}
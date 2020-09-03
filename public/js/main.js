/*************************************
 * standard functions
 ************************************/
function hideElement(element) {
    element.classList.add('d-none');
}
function showElement(element) {
    element.classList.remove('d-none');
}

document.addEventListener('DOMContentLoaded',(event) =>{
    let jokeN = document.getElementById('joke');
    if(jokeN.innerHTML === '') {
        hideElement(document.getElementById('joke-container'));
    } else {
        console.log(jokeN.innerHTML);
    }
})

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
    // processing results
    if (joke.type == "single") {
        document.getElementById('joke').innerHTML = joke.joke;
    } else {
        document.getElementById('joke').innerHTML = joke.setup + '<br /> <br />' + joke.delivery;
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

function randomJoke() {
    let ajax = new XHRRequest(processUniqueResult, '1-100');
}
function specifiedJoke(jokeApiId) {
    let ajax = new XHRRequest(processMultipleResults, jokeApiId.toString());
}
/*function specifiedJokesArray(array) {
    // Calls all jokes whose id is in the array
    // returns array of jokes
    for(let i = 0; i<array.length ; i++) {
        let joke = new Joke(i);
        console.log(joke);
    }*/
    /*array.foreach(item => {
        let joke = new Joke(item);
        console.log(joke);
    });*/
//}
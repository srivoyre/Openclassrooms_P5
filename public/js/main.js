function hide(element) {
    element.classList.add('d-none');
}

function showHiddenElement(element) {
    element.classList.remove('d-none');
}
document.addEventListener('DOMContentLoaded',(event) =>{
    let jokeN = document.getElementById('joke');

    if(jokeN.innerHTML === '') {
        hide(document.getElementById('joke-container'));
    } else {
        console.log(jokeN.innerHTML);
    }
})
function changeURLParam(elementId, jokeId) {
    var jokeUrl = new URL(document.getElementById(elementId).getAttribute('href'), 'http://localhost:8080/projects/OC_P5/public/');
    console.log(jokeUrl);
    var search_params = jokeUrl.searchParams;
    console.log(search_params);

    search_params.set('jokeApiId', jokeId);

    jokeUrl.search = search_params.toString();

    var new_url = jokeUrl.toString();

    document.getElementById(elementId).setAttribute('href', new_url);
    //document.getElementById('flagJokeBtn').setAttribute('href', new_url);

// output : http://demourl.com/path?id=100&topic=main
    console.log(new_url);
}
function joke(idRange = 1-100) {

    let newJoke = document.getElementById('newJoke');
    var baseURL = "https://sv443.net/jokeapi/v2";
    var categories = ["Programming", "Miscellaneous", "Pun"];

    var params = [
        "blacklistFlags=nsfw,religious,racist",
        "idRange=" + idRange
    ];
    var xhr = new XMLHttpRequest();
    xhr.open("GET", baseURL + "/joke/" + categories.join(",") + "?" + params.join("&"));

    newJoke.addEventListener('click', () => {
        showHiddenElement(document.getElementById('joke-container'));
            if (xhr.readyState == 4 && xhr.status < 300) // readyState 4 means request has finished + we only want to parse the joke if the request was successful (status code lower than 300)
            {
                var randomJoke = JSON.parse(xhr.responseText);

                changeURLParam('saveJokeBtn', randomJoke.id);
                changeURLParam('flagJokeBtn', randomJoke.id);

                if (randomJoke.type == "single") {
                    // If type == "single", the joke only has the "joke" property
                    document.getElementById('joke').innerHTML = randomJoke.joke;
                    //console.log(randomJoke.joke);
                } else {
                    // If type == "single", the joke only has the "joke" property
                    document.getElementById('joke').innerHTML = randomJoke.setup + '<br /> <br />' + randomJoke.delivery;
                }
            } else if (xhr.readyState == 4) {
                console.log("Error while requesting joke.\n\nStatus code: " + xhr.status + "\nServer response: " + xhr.responseText);
            }

        }
    );

    /*xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status < 300) // readyState 4 means request has finished + we only want to parse the joke if the request was successful (status code lower than 300)
        {
            var randomJoke = JSON.parse(xhr.responseText);

            console.log(randomJoke.type);
            console.log(xhr.responseText);

            if(randomJoke.type == "single")
            {
                // If type == "single", the joke only has the "joke" property
                document.getElementById('joke').innerHTML = randomJoke.joke;
                //console.log(randomJoke.joke);
            }
            else
            {
                // If type == "single", the joke only has the "joke" property
                document.getElementById('joke').innerHTML = [randomJoke.setup,'<br/>' + randomJoke.delivery];
            }
        }
        else if(xhr.readyState == 4)
        {
            alert("Error while requesting joke.\n\nStatus code: " + xhr.status + "\nServer response: " + xhr.responseText);
        }
    };*/

    xhr.send();
}
/*function specifiedJokesArray(array) {
    // Calls all jokes whose id is in the array
    // returns array of jokes
    var baseURL = "https://sv443.net/jokeapi/v2";
    var categories = ["Programming", "Miscellaneous", "Pun"];
    var params = [
        "blacklistFlags=nsfw,religious,racist",
        "idRange=28-28"
    ];
    var xhr = new XMLHttpRequest();
    array.foreach(item => {
        joke(item);
    });
}*/
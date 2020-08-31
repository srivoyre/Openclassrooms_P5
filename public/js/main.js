var baseURL = "https://sv443.net/jokeapi/v2";
var categories = ["Programming", "Miscellaneous", "Pun"];
var params = [
    "blacklistFlags=nsfw,religious,racist",
    "idRange=0-100"
];

var xhr = new XMLHttpRequest();
xhr.open("GET", baseURL + "/joke/" + categories.join(",") + "?" + params.join("&"));

xhr.onreadystatechange = function() {
    console.log(xhr.readyState);
    console.log(xhr.status);
    if(xhr.readyState == 4 && xhr.status < 300) // readyState 4 means request has finished + we only want to parse the joke if the request was successful (status code lower than 300)
    {
        var randomJoke = JSON.parse(xhr.responseText);

        if(randomJoke.type == "single")
        {
            // If type == "single", the joke only has the "joke" property
            document.getElementById('joke').innerHTML = randomJoke.joke;
            //console.log(randomJoke.joke);
        }
        else
        {
            // If type == "single", the joke only has the "joke" property
            document.getElementById('joke').innerHTML = randomJoke.setup;
            document.getElementById('joke').innerHTML = randomJoke.delivery;
            //console.log(randomJoke.setup);
            //console.log(randomJoke.delivery);
        }
    }
    else if(xhr.readyState == 4)
    {
        alert("Error while requesting joke.\n\nStatus code: " + xhr.status + "\nServer response: " + xhr.responseText);
    }
};

xhr.send();
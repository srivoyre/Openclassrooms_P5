class XHRRequest {

    constructor(callback, p_idRange = '1-100') {
        this.baseURL = 'https://sv443.net/jokeapi/v2';
        this.categories = ['Programming', 'Miscellaneous', 'Pun'];
        this.params = [
            'blacklistFlags=nsfw,religious,racist',
            'idRange=' + p_idRange
        ];
        this.xhr = new XMLHttpRequest();
        this.xhr.open("GET", this.baseURL + "/joke/" + this.categories.join(",") + "?" + this.params.join("&"));
        this.xhr.addEventListener('load', () => {
            if (this.xhr.readyState == 4 && this.xhr.status < 300) // readyState 4 means request has finished + we only want to parse the joke if the request was successful (status code lower than 300)
            {
                callback(this.xhr.responseText);

            } else if (this.xhr.readyState == 4) {
                console.log("Error while requesting joke.\n\nStatus code: " + this.xhr.status + "\nServer response: " + this.xhr.responseText);
            }

        });
        this.xhr.send();
    }
}
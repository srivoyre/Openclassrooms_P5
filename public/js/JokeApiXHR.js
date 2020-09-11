class JokeApiXHR {

    constructor(callback, random, idRange = '') {
        this.baseURL = 'https://sv443.net/jokeapi/v2';
        this.categories = ['Programming', 'Miscellaneous', 'Pun'];
        this.params = [
            'blacklistFlags=nsfw,religious,racist',
            'idRange=' + idRange
        ];
        this.ajax = new XMLHttpRequest();
        this.requestUrl = this.baseURL + '/joke/' + this.categories.join(',') + '?' + this.params.join('&');
        this.ajax.open('GET', this.requestUrl, true);
        this.ajax.addEventListener('load', () => {
            if (this.ajax.readyState == 4 && this.ajax.status < 300)
                // readyState 4 means request has finished + we only want to parse the joke if
                // the request was successful (status code lower than 300)
            {
                callback(this.ajax.responseText, random);

            } else if (this.ajax.readyState == 4) {
                console.log('Error while requesting joke.\n\nStatus code: ' + this.ajax.status + '\nServer response: ' + this.ajax.responseText);
            }

        });
        this.ajax.send();
    }
}
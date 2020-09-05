class Joke {

    constructor(param, random) {
        this.category = param.category;
        this.error = param.error ;
        this.flags = param.flags;
        this.id = param.id;
        this.joke = param.joke;
        this.lang = param.lang;
        this.type = param.type;
        this.setup = param.setup;
        this.delivery = param.delivery;
        this.random = random;
        this.container = this.setJokeContainer();
    }

    setJokeContainer() {
        if(this.random) {
            this.setRandomJokeActions();
            return this.container = document.getElementById('joke');
        } else {
            return this.container = document.getElementById('joke' + this.id);
        }
    }

    createJokeContent() {
        const jokeContent = () => {
            if (this.type == 'single') {
                return this.joke;
            } else {
                return this.setup + '<br /> <br />' + this.delivery;
            }
        }
        this.container.innerHTML = jokeContent();
        return this.container;
    }

    setRandomJokeActions() {
        this.setDynamicApiId('saveJokeBtn');
        this.setDynamicApiId('removeSavedJokeBtn');
        this.setDynamicApiId('flagJokeBtn');
    }

    setDynamicApiId(elementId) {
        let url = new URL(document.getElementById(elementId).getAttribute('href'), 'http://localhost:8080/projects/OC_P5/public/');
        let search_params = url.searchParams;
        search_params.set('jokeApiId', this.id);
        url.search = search_params.toString();
        let new_url = url.toString();
        document.getElementById(elementId).setAttribute('href', new_url);
    }

}
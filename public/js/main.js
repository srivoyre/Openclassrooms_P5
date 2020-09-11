/*************************************
 * variables declaration
 ************************************/
let savedJokesArray;
let filteredJokesArray;

/*************************************
 * standard functions
 ************************************/
function hideElement(element) {
    /*if (!element.classList.contains('d-none')) {
        element.classList.add('d-none');
    }*/
    addClass(element, 'd-none');
}

function showElement(element) {
    /*if (element.classList.contains('d-none')) {
        element.classList.remove('d-none');
    }*/
    removeClass(element, 'd-none')
}

function addClass(element, className) {
    if (!element.classList.contains(className)) {
        element.classList.add(className);
    }
}

function removeClass(element, className) {
    if (element.classList.contains(className)) {
        element.classList.remove(className);
    }
}

/****************************************
 * Forms validation
 ****************************************/
function checkUserInput() {
    checkPseudo();
    checkEmail();
    checkPassword();
    checkFormSubmission();
}

function checkPseudo() {
    let pseudo = document.getElementById('pseudo');

    if (pseudo !== null) {
        pseudo.addEventListener('input', (e) => {
            return checkInputMinLength(pseudo, e.target.value, 3);
        });
    }
}

function checkEmail() {
    let email = document.getElementById('email');

    if (email !== null) {
        email.addEventListener('input', (e) => {
            const emailRegex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

            if (emailRegex.test(e.target.value) === true) {
                return validateInput(email, true);
            } else {
                return validateInput(email, false);
            }
        });
    }
}

function checkPassword() {
    let password = document.getElementById('password');
    let newPassword = document.getElementById('newPassword');

    if (password !== null) {
        password.addEventListener('input', (e) => {
            return checkInputMinLength(password, e.target.value, 6);
        });
    }
    if (newPassword !== null) {
        newPassword.addEventListener('input', (e) => {
            return checkInputMinLength(newPassword, e.target.value, 6);
        });
    }
}

function checkInputMinLength(elt, input, length) {
    if (input.length < length) {
        return validateInput(elt, false);
    } else {
        return validateInput(elt, true);
    }
}

function validateInput(elt, validInput) {
    if (validInput === false) {
        addClass(elt, 'is-invalid');
        removeClass(elt, 'is-valid');
        return false;
    } else {
        addClass(elt, 'is-valid');
        removeClass(elt, 'is-invalid')
        return true;
    }
}

function checkFormSubmission() {
    'use strict';
    let forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    let validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}
/****************************************
 * App functions
 ****************************************/
function setUpHomePage() {
    if (document.getElementById('joke-container')
        && document.getElementById('joke').innerHTML === '') {
        hideElement(document.getElementById('joke-container'));
    }
    let newRandomJokeBtn = document.getElementById('newRandomJoke');
    if (newRandomJokeBtn !== null) {
        newRandomJokeBtn.addEventListener('click', ()=> {
            getJoke(true, '');
        }, false);
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

    for (let i = 0; i < jokesSpan.length; i++) {
        if (jokesSpan[i].innerHTML === '') {
            jokesSpan[i].innerHTML = '<span class="font-italic smaller">Sorry, joke not available at the moment. Come back in a few minutes!</span>';
        }
    }
}

const processResult = function (result, random) {
    let joke = new Joke(JSON.parse(result), random);
    if (random === true
        && filteredJokesArray !== null
        && filteredJokesArray.indexOf(joke.id.toString()) !== -1
    ) {
        getJoke(true);
    } else {
        joke.createJokeContent();
    }
    if (random === true) {
        showElement(document.getElementById('joke-container'));
    }
}

/****************************************
 * function called by user interaction
 ****************************************/
function getJoke(random = true, jokeApiId = '') {
    new JokeApiXHR(processResult, random, jokeApiId.toString());
}

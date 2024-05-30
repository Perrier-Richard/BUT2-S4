import * as utils from "./utils.js";
const form = document.querySelector('#login-form');

document.querySelector('#page-title').innerHTML = "Connexion"

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = form.elements.username.value;
    const password = form.elements.password.value;
    utils.requeteV2(
        '/sessions/connect','POST',{username:username,password:password},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    window.location.href = "index.php";
                }
            }
        }
    )
});
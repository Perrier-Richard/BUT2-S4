import * as utils from "./utils.js";

const footer = document.querySelector('footer');
const header = document.querySelector('header');
const body = document.querySelector('body');
const sectionBox = document.querySelectorAll('.section-box')

/**
 * Connection or disconnection form
 * @type {HTMLFormElement}
 */

document.querySelector('#burger').addEventListener('click',() => {
    document.querySelector('#burger').classList.toggle('open');
    document.querySelector('.burgermenu').classList.toggle('open');
});

/** */

let colorPage = utils.getCookie('colorPage');
switch (colorPage) {
    case 'default' || 'undefined' || null:
    footer.style.backgroundColor = "#79A3FF";
    header.style.backgroundColor = "#79A3FF";
    break;

    case 'pink' :
    footer.style.backgroundColor = "#FF69B4"
    header.style.backgroundColor = "#FF69B4"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#FF69B4"
    });
    break;

    case 'night' :
    footer.style.backgroundColor = "#474758"
    header.style.backgroundColor = "#474758"
    body.style.backgroundColor = "#5A5E6B"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#474758"
    });
    break;    

    case 'green' :
    footer.style.backgroundColor = "#87E990"
    header.style.backgroundColor = "#87E990"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#87E990"
    });
    break;   

    case 'purple' :
    footer.style.backgroundColor = "#9683EC"
    header.style.backgroundColor = "#9683EC"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#9683EC"
    });
    break;   

    case 'coquelicot' :
    footer.style.backgroundColor = "#C60800"
    header.style.backgroundColor = "#C60800"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#C60800"
    });
    break;

    case 'gold' :
    footer.style.backgroundColor = "#DAA520"
    header.style.backgroundColor = "#DAA520"
    sectionBox.forEach(box => {
        box.style.backgroundColor = "#DAA520"
    });
    break;
}


/**
 * Check if someone is connected on this session
 * Display connection or disconnection form
 */
function checkConnection() {
    utils.requeteV2(
        '/sessions/checkConnect','GET',{},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {

                if (obj.result) {
                    
                    let logout = document.querySelector('#connect-button');
                    logout.innerHTML = "<a href='#'>Déconnexion</a>"

                    logout.addEventListener('click',() => {
                        utils.requeteV2(
                            '/sessions/disconnect','POST',{},
                            function (obj) {
                                if ('error' in obj) {
                                    console.log(obj.error);
                                } else {
                                    window.location.href = "index.php";
                                }
                            }
                        )
                    });

                } else {
                    document.querySelector('#connect-button').innerHTML = "<a href='login.php'>Connexion</a>"
                    
                }
            }
        }
    )
}

checkConnection();


import * as utils from "./utils.js";
const settings_form = document.querySelector('#form-settings');
const account_form = document.querySelector('#form-account');
document.querySelector('#page-title').innerHTML = "Options"

settings_form.elements.ticketsPerPage.value = utils.getCookie("ticketsPerPage");
settings_form.elements.commentsPerPage.value = utils.getCookie("commentsPerPage");
settings_form.elements.colorPage.value = utils.getCookie("colorPage");



utils.requeteV2

let colorPage = utils.getCookie('colorPage');
switch (colorPage) {
    case "night":
        document.querySelector('form').style.color = "white";
        break;
}

settings_form.addEventListener('submit',(event) => {
    event.preventDefault();

    const ticketsPerPage = settings_form.elements.ticketsPerPage.value;
    const commentsPerPage = settings_form.elements.commentsPerPage.value;
    const colorPage = settings_form.elements.colorPage.value;

    utils.setCookie('ticketsPerPage',ticketsPerPage);
    utils.setCookie('commentsPerPage',commentsPerPage);
    utils.setCookie('colorPage', colorPage);

    window.location.href = window.location.href;

})


utils.requeteV2(
    '/sessions/checkConnect','GET',{},
    function (obj) {
        if ('error' in obj) {
            console.log(obj.error);
        } else {
            if (obj.result != false) {

                account_form.style.visibility = "visible";
                account_form.elements.username0.value = obj.result;
                account_form.elements.username.value = obj.result;

                account_form.addEventListener('submit',(event) => {
                    event.preventDefault();
                
                    const currentUsername = account_form.elements.username0.value;
                    const currentPassword = account_form.elements.password3.value;
                
                    const newUsername = account_form.elements.username.value;
                    const newPassword = account_form.elements.password.value;
                    const confirmPassword = account_form.elements.password2.value;
                
                    if (newPassword !== confirmPassword) {
                        alert("Les mots de passe ne correspondent pas");
                        return;
                    } else {
                        utils.requeteV2("/users/changePassword","POST", {currentUsername: currentUsername,newUsername: newUsername,currentPassword: currentPassword,newPassword: newPassword}, (obj) => {
                            if (obj.result == true) {
                                alert("Mot de passe changé avec succès");
                                window.location.href
                            }
                        })
                    }
                
                })

            }
        }
    });




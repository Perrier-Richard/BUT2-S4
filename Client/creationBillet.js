import * as utils from "./utils.js";
const add_ticket_form = document.querySelector('#add-ticket-form');
const remove_image = document.querySelector('#DelImage');
const ticket_id = new URLSearchParams(window.location.search).get('id');
const image_label = document.querySelector('#addImage-label');

if ( window.screen.availWidth <= 600 ) {
    document.querySelector("#form-card").style.backgroundColor = "transparent";
}

if (ticket_id == null) {
    document.querySelector('#page-title').innerHTML = "Création d'un billet"
} else {
    document.querySelector('#page-title').innerHTML = "Edition d'un billet"
    document.querySelector('#add-image-span').innerHTML = "";
    utils.requeteV2(
        '/tickets/getTicket','GET',{id:ticket_id},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                add_ticket_form.elements.title.value = obj.result['titre']
                add_ticket_form.elements.content.value = obj.result['content']
                let converter = new showdown.Converter();
                document.querySelector('#preview').innerHTML = converter.makeHtml(utils.removeTags(obj.result['content']));
            }
        }
    )

}

let colorPage = utils.getCookie('colorPage');
switch (colorPage) {
    case "night":
        document.querySelector('h3').style.color = "white";
        document.querySelector('form').style.color = "white";
        break;
}

remove_image.addEventListener('click', (e) => {
    e.preventDefault();
    add_ticket_form.elements.addImage.value = null;
    image_label.innerHTML = "Ajouter une image";
});

add_ticket_form.elements.addImage.addEventListener('change', (e) => {
    image_label.innerHTML = e.target.files[0].name.slice(0,20) + (e.target.files[0].name.length > 20 ? "..." : "");
})

add_ticket_form.addEventListener('submit',(event) => {
    event.preventDefault();

    const title = add_ticket_form.elements.title.value;
    const content = add_ticket_form.elements.content.value;

    const form = new FormData(add_ticket_form);

    if (ticket_id == null) {
        fetch('./Server2/api/tickets/addTicket.php', {
            method: 'POST',
            body: form
        }).then(function(response) {
            return response.json();
        }).then((obj) => {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    window.location.href = "index.php";
                }
            }
        });
    } else {
        utils.requeteV2(
            '/tickets/updateTicket','PATCH',{id:ticket_id,title:title,content:content},
            function (obj) {
                if ('error' in obj) {
                    console.log(obj.error);
                } else {
                    window.location.href = "billet.php?id="+ticket_id;
                }
            }
        )
    }
});

document.querySelector('textarea').addEventListener('input', (e) => {
    let converter = new showdown.Converter();
    document.querySelector('#preview').innerHTML = converter.makeHtml(utils.removeTags(e.target.value));
})
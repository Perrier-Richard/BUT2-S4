import * as utils from "./utils.js";
const add_ticket_form = document.querySelector('#add-ticket-form');
const ticket_id = new URLSearchParams(window.location.search).get('id');
const text_area_holder = document.getElementById("text-area-holder");

if ( window.screen.availWidth <= 600 ) {
    document.querySelector("#form-card").style.backgroundColor = "transparent";
}

if (ticket_id == null) {
    document.querySelector('#page-title').innerHTML = "Création d'un billet"
} else {
    document.querySelector('#page-title').innerHTML = "Edition d'un billet"
    utils.requeteV2(
        '/tickets/getTicket','GET',{id:ticket_id, html:0},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                console.log(obj.ticket);
                console.log(obj.content);

                add_ticket_form.elements.title.value = obj.ticket['titre'];

                let converter = new showdown.Converter();

                for(let i = 0; i < obj.content.length; i++){
                    if(obj.content[i]['type'] == "text-div"){
                        createParaph(obj.content[i]['content']);
                    }

                    if(obj.content[i]['type'] == "image-div"){
                        createImage("Images/ticket_image/" + obj.content[i]['content']);
                    }

                    if(obj.content[i]['type'] == "sondage-div"){
                        createSondage(obj.content[i]['content']);
                    }
                }
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

add_ticket_form.elements.addImage.addEventListener('change', (e) => {
    image_label.innerHTML = e.target.files[0].name.slice(0,20) + (e.target.files[0].name.length > 20 ? "..." : "");
})

add_ticket_form.addEventListener('submit',(event) => {
    event.preventDefault();

    let formData = new FormData();

    const title = add_ticket_form.elements.title.value;

    formData = createFormData(formData);
    formData.append("title", title);

    for (const pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
    }

    if (ticket_id == null) {
        console.log("add");
        fetch('./Server2/api/tickets/addTicket.php', {
            method: 'POST',
            body: formData
        }).then(function(response) {
            return response.json();
        }).then((obj) => {
            console.log(obj);

            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    window.location.href = "index.php";
                }
            }
        });
    } else {
        console.log("update");
        formData.append("id", ticket_id);

        fetch('./Server2/api/tickets/updateTicket.php', {
            method: 'POST',
            body: formData
        }).then(function(response) {
            return response.json();
        }).then((obj) => {
            console.log(obj);

            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    window.location.href = "billet.php?id="+ticket_id;
                }
            }
        });
    }
});

function createFormData(formData){
    const content_div = text_area_holder.getElementsByTagName("div");
    let count = 0;

    for(let i = 0; i < content_div.length; i++){
        let content = [];
        let image = null;

        if(content_div[i].classList.contains("text-div")){
            const textarea = content_div[i].querySelector("#edit-text");

            if(textarea != null){
                content.push('text-div');
                content.push(textarea.value);
            }
        }

        else if(content_div[i].classList.contains("image-div")){
            const imageFile = content_div[i].getElementsByTagName("input")[0];

            if(imageFile != null){
                image = imageFile.files[0];
                content.push('image-div');
                content.push(image);
            }
        }

        else if(content_div[i].classList.contains("sondage-div")){
            let choice = content_div[i].getElementsByClassName("sondage-choice");

            if(choice.length <= 1) continue;

            content.push("sondage-div")

            for(let j = 0; j < choice.length; j++){
                const choiceValue = choice[j].querySelector("#choice");

                if(choiceValue != null){
                    content.push(choiceValue.value);
                }
            }
        }

        else{
            continue;
        }
        
        formData.append(count, content);
        if(image != null){
            formData.append(count, image);
            image = null;
        }
        count++;
    }

    return formData;
}

//----------------------------------\\

const add_paraph = document.querySelector("#addParaph");
const add_image = document.querySelector("#addImage");
const add_sondage = document.querySelector("#addSondage");

add_paraph.addEventListener('click', (e) => {
    e.preventDefault();

    createParaph();
});

add_image.addEventListener('click', (e) => {
    e.preventDefault();

    createImage();
});

add_sondage.addEventListener('click', (e) => {
    e.preventDefault();

    createSondage();
});

//----------------------------------\\

function createParaph(text){
    const newParaph = `
        <textarea id="edit-text" class="input" maxlength="5000" name="content" rows="7" cols="30"></textarea>
        <div id="preview"></div>
    `;

    const divText = document.createElement('div');
    divText.classList.add('paraph-text');
    divText.innerHTML = newParaph;

    const divParaph = document.createElement('div');
    divParaph.classList.add("text-div");

    text_area_holder.appendChild(divParaph);

    const removeParaph = document.createElement("button");
    removeParaph.innerText = "X";

    divParaph.appendChild(removeParaph);
    divParaph.appendChild(divText);

    let converter = new showdown.Converter();
    const text_div = document.getElementsByClassName("text-div");

    removeParaph.addEventListener('click', (e) => {
        e.preventDefault();

        text_area_holder.removeChild(divParaph);
    });

    if(text){
        let textArea = divText.querySelector("#edit-text");
        textArea.value = text;
    }

    for(let i = 0; i < text_div.length; i++){
        text_div[i].querySelector('textarea').addEventListener('input', (e) => {
            text_div[i].querySelector('#preview').innerHTML = converter.makeHtml(utils.removeTags(e.target.value));
        });

        text_div[i].querySelector('#preview').innerHTML = converter.makeHtml(utils.removeTags(text_div[i].querySelector('textarea').value));
    }

    return divParaph;
}

function createImage(src){
    const newImage = `
        <img style="width: 80%">
    `;

    const divView = document.createElement('div');
    divView.classList.add("image-preview");
    divView.innerHTML = newImage;

    const divImage = document.createElement('div');
    divImage.classList.add("image-div")

    text_area_holder.appendChild(divImage);  

    const addImageSrc = document.createElement("input");
    addImageSrc.type = "file";
    addImageSrc.name = "image";

    const addImageButton = document.createElement("button");
    addImageButton.innerText = "Change image";

    const removeImageButton = document.createElement("button");
    removeImageButton.innerText = "X";

    divImage.appendChild(addImageButton);
    divImage.appendChild(removeImageButton);
    divImage.appendChild(addImageSrc);
    divImage.appendChild(divView); 

    addImageButton.addEventListener('click', (e) => {
        e.preventDefault();

        addImageSrc.click();
    })

    removeImageButton.addEventListener('click', (e) => {
        e.preventDefault();

        text_area_holder.removeChild(divImage);
    });

    addImageSrc.addEventListener('change', (e) => {
        e.preventDefault();
        
        const file = addImageSrc.files[0];
        const imgPreview = divView.getElementsByTagName("img")[0];

        if (file && imgPreview) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imgPreview.src = e.target.result;
                imgPreview.style.width = "100%";
            };
            reader.readAsDataURL(file);
        }
    });

    if(src){
        let img = divView.getElementsByTagName("img")[0];
        img.src = src;
    }
}

function createSondage(choices){
    const newSondage = `
        <input type="radio">
        <input type="text" id="choice">
    `;

    let divChoice = document.createElement('div');
    divChoice.classList.add("sondage-choice");
    divChoice.innerHTML = newSondage;

    let divSondage = document.createElement('div');
    divSondage.classList.add("sondage-div");

    text_area_holder.appendChild(divSondage);

    const actionChoiceButton = document.createElement("div");

    const addChoiceButton = document.createElement("button");
    addChoiceButton.innerText = "+";

    const removeChoiceButton = document.createElement("button");
    removeChoiceButton.innerText = "-";

    actionChoiceButton.appendChild(addChoiceButton);
    actionChoiceButton.appendChild(removeChoiceButton)

    divSondage.appendChild(actionChoiceButton);

    if(choices){
        const choicesSplit = choices.split(",");

        for(let i = 0; i < choicesSplit.length; i++){
            let divChoice = document.createElement('div');
            divChoice.classList.add("sondage-choice");
            divChoice.innerHTML = newSondage;

            divSondage.appendChild(divChoice);

            let inputText = divChoice.querySelector("#choice");
            inputText.value = choicesSplit[i];
        }
    }else{
        divSondage.appendChild(divChoice);

        divChoice = document.createElement('div');
        divChoice.classList.add("sondage-choice");
        divChoice.innerHTML = newSondage;

        divSondage.appendChild(divChoice);
    }

    addChoiceButton.addEventListener('click', (e) => {
        e.preventDefault();

        let divChoice = document.createElement('div');
        divChoice.classList.add("sondage-choice");
        divChoice.innerHTML = newSondage;

        divSondage.appendChild(divChoice);
    });

    removeChoiceButton.addEventListener('click', (e) => {
        e.preventDefault();

        if (divSondage.lastElementChild) {
            divSondage.removeChild(divSondage.lastElementChild);
        }

        if (divSondage.children.length <= 2){
            text_area_holder.removeChild(divSondage);
        }
    });

    return divSondage;
}
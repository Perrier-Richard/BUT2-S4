import * as utils from "./utils.js";
const add_comment_form = document.querySelector('#form-commentaire');
const comment_list = document.querySelector('#list-comment');
const ticket_id = new URLSearchParams(window.location.search).get('id');
const ticket_img = document.querySelector('#billet-img');


/**
 * Number of comments per page
 * @type {int}
 */
let commentsPerPage = utils.getCookie('commentsPerPage');
if (commentsPerPage == null || commentsPerPage == "undefined") {
    utils.setCookie('commentsPerPage',5);
    commentsPerPage = 5;
}
/**
 * Number of currently displayed comments page
 * @type {int}
 */
let numberOfPage = 0;
/**
 * Number of displayable comments page
 * @type {int}
 */
let lastPageNumber = 1;

document.querySelector('#page-title').innerHTML = "Billet"

if ( window.screen.availWidth <= 600 ) {
    document.querySelector("#ticket").style.backgroundColor = "transparent";
}

/**
 * Display tickets details
 */
function initTicket() {
    utils.requeteV2(
        '/tickets/getTicket','GET',{id:ticket_id},
        function (obj) {
            if ( !('error' in obj) ) {
                console.log(obj);
                console.log(obj.content);
                document.querySelector('#titre-billet').innerHTML = obj.ticket['titre'];
                let converter = new showdown.Converter();
                const content = document.querySelector('#contenu-billet');
                content.innerHTML = "";
                for(let i = 0; i < obj.content.length; i++){
                    content.innerHTML += obj.content[i];
                }
                if (obj.ticket['image'] != null) {
                    ticket_img.innerHTML = "<img src='./Images/ticket_image/"+obj.ticket['image']+"' alt='Image du billet'/>";
                }
                let colorPage = utils.getCookie('colorPage');
                    switch (colorPage) {
                        case "night":
                            document.querySelector('#titre-billet').style.color = "white";
                            document.querySelector('#subtitle').style.color = "white";
                            document.querySelector('#comment-pseudo').style.color = "white";
                            document.querySelector('#contenu-billet').style.color = "rgb(200,200,200)";
                            break;
                    }
                utils.requeteV2(
                    '/comments/countComments','GET',{billet_id:ticket_id},
                    function (obj) {
                        if ( !('error' in obj) ) {
                            lastPageNumber = Math.ceil(obj.ticket[0][0]/commentsPerPage) -1;
                        }
                    }
                )
            } else {
                console.log(obj.error);
            }
        }
    )

}

/**
 * Display selected page of comments under the ticket
 * @param {int} page Index of the comments page to display
 */
function initComments(page) {
    utils.requeteV2(
        '/comments/getComments','GET',{billet_id:ticket_id,page:page*commentsPerPage,count:commentsPerPage},
        function (obj) {
            if ( !('error' in obj) ) {
                comment_list.innerHTML = "";
                numberOfPage = page;
                document.querySelector('#page-number').innerHTML = numberOfPage+1;
                if (obj.result.length == 0) {
                    comment_list.innerHTML = "Soyez le premier à commenter!"
                }

                const comment_template = document.querySelector('#template-comment').content;

                obj.result.forEach(comment => {
                    const commentNode = comment_template.cloneNode(true);
                    
                    const commendArticle = commentNode.querySelector('.comment-article');
                    commendArticle.setAttribute("id",comment.id)

                    const pseudo = commendArticle.querySelector('.pseudo-comment');
                    pseudo.innerHTML = comment.pseudo;
                    const contenu = commendArticle.querySelector('.contenu-comment');
                    contenu.innerHTML = comment.commentaire;
                    const date = commendArticle.querySelector('.date-comment');
                    date.innerHTML = comment.date;

                    let colorPage = utils.getCookie('colorPage');
                    switch (colorPage) {
                        case "night":
                            pseudo.style.color = "white";
                            contenu.style.color = "rgb(200,200,200)";
                            date.style.color = "rgb(200,200,200)";
                            break;
                    }

                    comment_list.append(commentNode);
                });
                initAdmin()
            } else {
                console.log(obj.error);
            }
        }
    )
}

/**
 * Initialize admin only options for comments ( remove comment )
 */
 function initAdmin() {
    utils.requeteV2(
        '/sessions/checkConnect','GET',{},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    const edit_ticket = document.querySelector('#edit-billet');
                    const trash_ticket = document.querySelector('#trash-billet');
                    edit_ticket.style.visibility = "visible"
                    trash_ticket.style.visibility = "visible"


                    edit_ticket.addEventListener('click',() => {
                        window.location.href = "creationBillet.php?id="+ticket_id;
                    })

                    trash_ticket.addEventListener('click',() => {
                        utils.requeteV2(
                            '/tickets/deleteTicket','DELETE',{id:ticket_id},
                            function (obj) {
                                if ('error' in obj) {
                                    console.log(obj.error);
                                } else {
                                    window.location.href = "index.php";
                                }
                            }
                        )
                    })

                    comment_list.querySelectorAll('.comment-article').forEach(comment => {
                        const trash_bin = comment.querySelector('.trash-comment');

                        trash_bin.addEventListener('click',() => {
                            utils.requeteV2(
                                '/comments/deleteComment','DELETE',{id:comment.id},
                                function (obj) {
                                    if ('error' in obj) {
                                        console.log(obj.error);
                                    } else {
                                        initTicket();
                                        initComments(0);
                                    }
                                }
                            )
                        })
                        if ( window.screen.availWidth <= 600 ) {
                            trash_bin.style.visibility = "visible";
                        } else {
                            comment.addEventListener('mouseover',() => {
                                trash_bin.style.visibility = "visible";
                            })
                            comment.addEventListener('mouseout',() => {
                                trash_bin.style.visibility = "hidden";
                            })
                        }
                        
                    });
                }
            }
        }
    );
}

/**
 * Adds submit event to the add comment form
 */
 add_comment_form.addEventListener('submit',(event) => {
    event.preventDefault();
    const pseudo = add_comment_form.elements.pseudo.value;
    const comment = add_comment_form.elements.comment.value;
    utils.requeteV2(
        '/comments/createComment','POST',{billet_id:ticket_id,pseudo:pseudo,content:comment},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                initTicket();
                initComments(0);
            }
        }
    )
});

/**
 * Initialize clickable page selector to navigate trough comments pages
 */
 document.querySelectorAll('.page-select').forEach(p_selector => {
    p_selector.addEventListener('click', () => {
        if (p_selector.classList.contains('next') && numberOfPage+1 <= lastPageNumber) {
            initComments(numberOfPage+1,5);
        } else if (p_selector.classList.contains('previous') && numberOfPage-1 >= 0) {
            initComments(numberOfPage-1,5);
        } else if (p_selector.classList.contains('first') && numberOfPage != 0) {
            initComments(0,5);
        } else if (p_selector.classList.contains('last') && numberOfPage != lastPageNumber) {
            initComments(lastPageNumber,5);
        }
    })
});


initTicket()
initComments(0)
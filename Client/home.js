import * as utils from "./utils.js";
const ticket_list = document.querySelector('#liste-billets');

/**
 * Number of tickets per page
 * @type {int}
 */
let ticketsPerPage = utils.getCookie('ticketsPerPage');
if (ticketsPerPage == null || ticketsPerPage == "undefined") {
    utils.setCookie('ticketsPerPage',5);
    ticketsPerPage = 5;
}
/**
 * Number of currently displayed tickets page
 * @type {int}
 */
let numberOfPage = utils.getCookie('pageNumber');
if (numberOfPage == null || numberOfPage == "undefined") {
    utils.setCookie('pageNumber',0);
    numberOfPage = 0;
}
/**
 * Number of displayable tickets page
 * @type {int}
 */
let lastPageNumber = 1;

document.querySelector('#page-title').innerHTML = "Accueil"

if ( window.screen.availWidth <= 600 ) {
    document.querySelector("#liste-billets").style.backgroundColor = "transparent";
}




/**
 * Display a page of selectable tickets on the home page
 * @param {int} page Page number to display on the home page
 */
function initTickets(page) {

    utils.requeteV2(
        '/tickets/getTickets','GET',{page:page*ticketsPerPage,count:ticketsPerPage},
        function (obj) {
            if ( !('error' in obj) ) {

                ticket_list.querySelectorAll('.billet').forEach(ticketNode => {
                    ticketNode.remove();
                })
                ticket_list.querySelectorAll('hr').forEach(hrNode => {
                    hrNode.remove();
                })
                utils.setCookie('pageNumber',page);
                numberOfPage = page;
                document.querySelector('#page-number').innerHTML = numberOfPage+1;
                const ticket_template = document.querySelector('#template-billet').content;
                let first = true

                obj.result.forEach(billet => {
                    const billetNode = ticket_template.cloneNode(true);

                    const title = billetNode.querySelector('.titre-billet');
                    title.innerHTML = billet.titre;

                    const content = billetNode.querySelector('.contenu-billet');
                    let splitter = 200
                    while (billet.content[splitter] != " " && splitter < billet.content.length) {
                        splitter++;
                    }
                    let converter = new showdown.Converter();
                    const result = utils.removeTags( converter.makeHtml(billet.content.slice(0,splitter) + (splitter < billet.content.length ? " [...]" : "")))
                    content.innerHTML = result;

                    const date = billetNode.querySelector('.post-date');
                    date.innerHTML = billet.date;
                    const comments = billetNode.querySelector('.comment-count');
                    

                    let colorPage = utils.getCookie('colorPage');
                    switch (colorPage) {
                        case "night":
                            title.style.color = "white";
                            content.style.color = "rgb(200,200,200)";
                            date.style.color = "rgb(200,200,200)"
                            comments.style.color = "rgb(200,200,200)";
                            break;
                    }

                    const selector = billetNode.querySelector('.selector');
                    selector.addEventListener('click',() => {
                        window.location.href = "billet.php?id="+billet.id;
                    });
                    if (!first) { ticket_list.append(document.createElement('hr')); } else { first = false; }
                    ticket_list.append(billetNode);

                    utils.requeteV2(
                        '/comments/countComments','GET',{billet_id:billet.id},
                        function (obj) {
                            if ( !('error' in obj) ) {
                                comments.innerHTML = obj.result[0][0] + " commentaires";
                            }
                        }
                    )

                });

            } else {
                console.log(obj.error);
            }
        }
    )

}

/**
 * Initialize admin only options ( add-ticket button )
 */
function initAdmin() {
    utils.requeteV2(
        '/sessions/checkConnect','GET',{},
        function (obj) {
            if ('error' in obj) {
                console.log(obj.error);
            } else {
                if (obj.result != false) {
                    const add_ticket_holder = document.querySelector('#add-ticket-template').content.cloneNode(true);
                    ticket_list.prepend(add_ticket_holder);
                    const add_ticket_button = ticket_list.querySelector('#add-ticket');
                    add_ticket_button.addEventListener('click',() => {
                        window.location.href = "creationBillet.php";
                    })
                }
            }
        }
    );
}

/**
 * Calculate the number of pages depending the number of tickets
 */
function calculateMaxTicketPage() {
    utils.requeteV2(
        '/tickets/countTicket','GET',{},
        function (obj) {
            if ( !('error' in obj) ) {
                lastPageNumber = Math.ceil(obj.result/ticketsPerPage) - 1;
            } else {
                console.log(obj.error);
            }
        }
    )
}

/**
 * Initialize clickable page selector to navigate trough tickets pages
 * @param {HTMLElement} p_selector Page selector button to initialize
 */
function initPageSelector(p_selector) {
    p_selector.addEventListener('click', () => {
        if (p_selector.classList.contains('next') && numberOfPage+1 <= lastPageNumber) {
            initTickets(numberOfPage+1);
        } else if (p_selector.classList.contains('previous') && numberOfPage-1 >= 0) {
            initTickets(numberOfPage-1);
        } else if (p_selector.classList.contains('first') && numberOfPage != 0) {
            initTickets(0);
        } else if (p_selector.classList.contains('last') && numberOfPage != lastPageNumber) {
            initTickets(lastPageNumber);
        }
    })
}


document.querySelectorAll('.page-select').forEach(p_selector => {
    initPageSelector(p_selector);
})

initAdmin();
initTickets(+utils.getCookie('pageNumber'));
calculateMaxTicketPage();



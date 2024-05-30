import * as utils from "./utils.js";

window.cookieconsent.initialise({
    palette: {
      "popup": { "background": "#252e39", "link": "#009696" },
      "button": { "background": "#009696" }
    },
    theme: "classic",
    type: "opt-in",
    content: {
      "message": "Ce site utilise des cookies pour vous offrir le meilleur service. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.",
      "allow": "J'ai compris",
      "deny": "Je refuse",
      "policy": 'Cookies',
      "target": '_blank'
    },
    onStatusChange: (status) => {
      if (status == 'deny') {
        disableCookies();
      }
      if (status == 'allow') {
        enableCookies();
      }
    }
  });

  if (utils.getCookie("cookieconsent_status") != 'deny') {
    enableCookies();
  }
  else{
    disableCookies();
  }
  
  function enableCookies() {
    utils.setCookie('ticketsPerPage',utils.getCookie("ticketsPerPage"));
    utils.setCookie('commentsPerPage',utils.getCookie("commentsPerPage"));
    utils.setCookie('colorPage',utils.getCookie("colorPage"));
  }
  
  function disableCookies() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        if (!name.includes("cookieconsent_status") && !name.includes("PHPSESSID")){
          if(name.includes("ticketsPerPage")){
            utils.setCookie(name,5);
          }
          else if(name.includes("commentsPerPage")){
            utils.setCookie(name,5);
          }
          else{
            utils.setCookie(name,""); 
          }
        }
      }
  }
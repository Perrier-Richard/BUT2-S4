import * as utils from "./utils.js";

/**
 * Pre-made request to send to the server
 * @param {*} data data to send to the server. Contains function name and arguments
 * @param {*} callback callback function to execute once the request is done
 */
 export function requete(data,callback) {
    fetch('./Server/server.php',{
        method : "POST",
        headers : {
            'Content-type' : 'application/json',
            'Accept' : 'application/json'
        },
        body : JSON.stringify(data),
    }).then(function(response) {
        return response.json();
    }).then(callback);
}

/**
 * Pre-made request to send to the server
 * @param {*} request specific function to execute on the server
 * @param {*} method method to use for request
 * @param {*} data data to send to the server
 * @param {*} callback callback function to execute once the request is done
 */
export function requeteV2(request,method,data,callback) {
    if (method == "GET") {
        let query = "./Server2/api"+request+".php?";
        for (let key in data) {
            query += key+"="+data[key]+"&";
        }

        fetch(query,{
            method : method,
            headers : {
                'Content-type' : 'application/json',
                'Accept' : 'application/json'
            },
        }).then(function(response) {
            return response.json();
        }).then(callback);

    } else {

        fetch('./Server2/api'+request+'.php',{
            method : method,
            headers : {
                'Content-type' : 'application/json',
                'Accept' : 'application/json'
            },
            body : JSON.stringify(data),
        }).then(function(response) {
            return response.json();
        }).then(callback);

    }
}

export function setCookie(name, value) {
    document.cookie = name + "=" + value + ";path=/";
}

export function getCookie(name) {
    let result;
    const decodedCookie = decodeURIComponent(document.cookie).split(';');
    decodedCookie.forEach(cookie => {
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) != -1) {
            result = cookie.substring(name.length+1,cookie.length);
        }
    });
    return result;
}

export function removeTags(str) {
    if ((str===null) || (str===''))
        return '';
    else
        return str.replace( /(<([^>]+)>)/ig, '');
}
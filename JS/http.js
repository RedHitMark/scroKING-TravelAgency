//include jquery files
var imported = document.createElement('script');
imported.src = 'JS/jquery.min.js';
document.head.appendChild(imported);

function post(url, success_f, error_f, data) {
    if (success_f && typeof success_f === "function") {
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: JSON.stringify(data),
            contentType: 'application/json',
            statusCode: {
                200 : success_f,
                400: error_f,
                500: error_f
            }
        });
    } else {
        return ;
    }
}


function get(url, success_f, error_f, data) {
    if (success_f && typeof success_f === "function") {
        $.ajax({
            url: url,
            type: "get", 
            dataType: 'json',
            data: JSON.stringify(data),
            statusCode: {
                200 : success_f,
                400: error_f,
                500: error_f
            }
        });
    } else {
        return ;
    }
}
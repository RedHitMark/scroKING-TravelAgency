//include jquery files
var imported = document.createElement('script');
imported.src = 'JS/jquery.min.js';
document.head.appendChild(imported);

function post(url, data, functions) {
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: JSON.stringify(data),
        contentType: 'application/json',
        statusCode: functions
    });
}


function get(url, data, functions) {
    $.ajax({
        url: url,
        type: "get",
        dataType: 'json',
        data: JSON.stringify(data),
        statusCode: functions
    });
}

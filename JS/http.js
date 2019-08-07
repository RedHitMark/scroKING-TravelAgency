function post(url, success, data) {
    //if (success && typeof success == function {console.log("ok");}

    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        success: success(data),
        data: JSON.stringify(data)
    });
}

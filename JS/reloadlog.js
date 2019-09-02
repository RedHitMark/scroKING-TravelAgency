function check_login_status() {
    function login_success(json_response) {
        console.log(json_response);
        $(".nolog").css({ 'display' : 'none'});
        $(".yeslog").css({ 'display' : 'flex'});
        const username =json_response.username;
        $( ".benvenuto" ).html("Benvenuto, " +  username);

    }
    function request_timeout(json_response) {
        alert("sessione scaduta");
        $(".yeslog").hide();
    }

    function login_unauthorized(json_response) {
        $(".yeslog").hide();
    }

    function login_internal_server_error(json_response) {
        alert("errore del server");
        $(".yeslog").hide();
    }
    let login_functions = {
        200: login_success,
        408: request_timeout,
        401: login_unauthorized,
        500: login_internal_server_error
    };
    post('api/user/check.php', null, login_functions);

    

}

    check_login_status();
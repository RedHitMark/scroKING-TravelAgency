$('.logout').click(function(e){
    e.preventDefault();

    function log_out(){
        function log_out_success(json_response){
            console.log(json_response);
            alert("Log-out effettuato");

            $(location).attr("href", "index.htm");
        }
        function log_out_internal_server_error(){
            alert("Problema del server, riprovare più tardi");
            $(location).attr("href", "index.htm");
        }

        let log_out_functions = {
            200: log_out_success,
            500: log_out_internal_server_error
        };
    
        post('api/user/logout.php', null, log_out_functions);
    }
    
    log_out();

});


var http = require("http");
var url = require('url');
var utils = require('./utils');


const SERVER_PORT = 8080;


function onRequest(request, response) {
    try {
        let client_ip = utils.getClientAddress(request);
        let url_obj = url.parse(request.url, true);
        let query_params = url_obj.query;
        let path_name = url_obj.pathname;

        console.log("Richiesta ricevuta da: " + client_ip);

        switch(path_name) {
            case "/ricarca": //put money in wallet
                response.writeHead(200, {"Content-Type": "text/json"});

                //@TODO call query of add new transaction always success ahahha

                response.end();
                break;

            case "/prenotazione_viaggio": //remove money in waller if enough
                response.writeHead(200, {"Content-Type": "text/json"});

                //@TODO call query of add new transaction only if

                response.end();
                break;

            case "/get_wallet": //returns money and all transactions
                response.writeHead(200, {"Content-Type": "text/json"});

                //always success

                response.end();
                break;

            default:
                response.writeHead(404, {"Content-Type": "text/json"});
                response.write("404 Not Found\n");
                response.end();
                break;
        }
    } catch (e) {
        //internal server error
        response.writeHead(500, {"Content-Type": "text/json"});

        let json_response = {
            message : "Errore del server",
            verbose : e.message
        };

        response.write(JSON.stringify(json_response));
        response.end();
    }
}

http.createServer(onRequest).listen(SERVER_PORT);
console.log("Server avviato ed in ascolto sulla porta " + SERVER_PORT);



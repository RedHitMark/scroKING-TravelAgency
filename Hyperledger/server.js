var http = require("http");
var url = require('url');
var utils = require('./utils');

var chaincode_query = require('./scrocco_network/javascript/query');


const SERVER_PORT = 34518;


async function onRequest(request, response) {
    try {
        let client_ip = utils.getClientAddress(request);
        let url_obj = url.parse(request.url, true);
        let query_params = url_obj.query;
        let path_name = url_obj.pathname;

        console.log("Richiesta ricevuta da: " + client_ip);

        switch (path_name) {
            case "/ricarca": //put money in wallet
                if (query_params.user_id && query_params.money && query_params.description) {
                    await chaincode_query.ricarica(query_params.user_id, query_params.money, query_params.description);

                    let json_response = {
                        message: "Ricarica effettuata con successo"
                    };

                    //Success
                    response.writeHead(200, {"Content-Type": "text/json"});
                    response.write(JSON.stringify(json_response));
                    response.end();
                } else {
                    let json_response = {
                        message: "Parametri mancanti"
                    };

                    //Bad Request
                    response.writeHead(400, {"Content-Type": "text/json"});
                    response.write(JSON.stringify(json_response));
                    response.end();
                }
                break;

            case "/prenotazione_viaggio": //remove money in waller if enough
                if (query_params.user_id && query_params.money && query_params.description) {
                    const wallet = chaincode_query.getWallet(user_id);

                    if(wallet.wallet > money) {
                        await chaincode_query.prenotazioneViaggio(query_params.user_id, query_params.money, query_params.description);

                        let json_response = {
                            message: "Prenotazione effettuata con successo"
                        };

                        //Success
                        response.writeHead(200, {"Content-Type": "text/json"});
                        response.write(JSON.stringify(json_response));
                        response.end();
                    } else {
                        let json_response = {
                            message: "Non ci sono abbastanza fondi nel wallet"
                        };

                        //Not Acceptable
                        response.writeHead(406, {"Content-Type": "text/json"});
                        response.write(JSON.stringify(json_response));
                        response.end();
                    }
                } else {
                    let json_response = {
                        message: "Parametri mancanti"
                    };

                    //Bad Request
                    response.writeHead(400, {"Content-Type": "text/json"});
                    response.write(JSON.stringify(json_response));
                    response.end();
                }
                break;

            case "/get_wallet": //returns money and all transactions
                if (query_params.user_id) {
                    json_response = await chaincode_query.getWallet();

                    //Success
                    response.writeHead(200, {"Content-Type": "text/json"});
                    response.write(JSON.stringify(json_response));
                    response.end();
                } else {
                    let json_response = {
                        message: "Parametri mancanti"
                    };

                    //Bad Request
                    response.writeHead(400, {"Content-Type": "text/json"});
                    response.write(JSON.stringify(json_response));
                    response.end();
                }


                response.writeHead(200, {"Content-Type": "text/json"});

                let result = await chaincode_query.getWallet();
                response.write(JSON.stringify(result));
                response.end();
                break;

            default:
                let json_response = {
                    message: "Not found",
                };

                //Not found
                response.writeHead(404, {"Content-Type": "text/json"});
                response.write(JSON.stringify(json_response));
                response.end();
                break;
        }
    } catch (e) {
        let json_response = {
            message: "Errore del server",
            verbose: e.message
        };

        //Internal Server Rrror
        response.writeHead(500, {"Content-Type": "text/json"});
        response.write(JSON.stringify(json_response));
        response.end();
    }
}

//init blockchain

http.createServer(onRequest).listen(SERVER_PORT);
console.log("Server avviato ed in ascolto sulla porta " + SERVER_PORT);



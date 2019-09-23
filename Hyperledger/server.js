const http = require("http");
const url = require('url');
const  utils = require('./utils');

const chaincode = require('./scrocco_network/javascript/query');


const SERVER_PORT = 34518;


async function onRequest(request, response) {
    try {
        let client_ip = utils.getClientAddress(request);
        let url_obj = url.parse(request.url, true);
        let query_params = url_obj.query;
        let path_name = url_obj.pathname;

        console.log("Richiesta ricevuta da: " + client_ip);
        
        await chaincode.init();

        switch (path_name) {
            case "/ricarica": //put money in wallet
                if (query_params.user_id && query_params.money && query_params.description) {
                    await chaincode.ricarica(query_params.user_id, query_params.money, query_params.description);

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
                    const wallet = chaincode.getWallet(query_params.user_id);

                    if(wallet.wallet > query_params.money) {
                        await chaincode.prenotazioneViaggio(query_params.user_id, query_params.money, query_params.description);

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
                    let json_response = await chaincode.getWallet(query_params.user_id);

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

            case "/read_all":
                let json = await chaincode.readAll();

                //Success
                response.writeHead(200, {"Content-Type": "text/json"});
                response.write(JSON.stringify(json));
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

http.createServer(onRequest).listen(SERVER_PORT);
console.log("Server avviato ed in ascolto sulla porta " + SERVER_PORT);



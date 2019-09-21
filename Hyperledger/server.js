var http = require("http");
var url = require('url');
var utils = require('./utils');


const SERVER_PORT = 8080;


function onRequest(request, response) {
    let client_ip = utils.getClientAddress(request);
    let url_obj = url.parse(request.url, true);
    let query_params = url_obj.query;
    let path_name = url_obj.pathname;

    console.log("Richiesta ricevuta da: " + client_ip);

    switch(path_name) {
        case "/getTransactions":
            response.writeHead(200, {"Content-Type": "text/plain"});
            response.write("Richiesta ricevuta");
            //do something
            break;

        case "/newTransaction":
            response.writeHead(200, {"Content-Type": "text/plain"});
            response.write("Richiesta ricevuta");
            //do something
            break;

        default:
            response.writeHead(404, {"Content-Type": "text/plain"});
            response.write("404 Not Found\n");
            response.end();
            break;

    }
}
http.createServer(onRequest).listen(SERVER_PORT);
console.log("Server avviato ed in ascolto sulla porta " + SERVER_PORT);



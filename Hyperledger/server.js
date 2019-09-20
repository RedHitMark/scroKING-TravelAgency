var http = require("http");
var url = require('url');


const SERVER_PORT = 8080;


function onRequest(request, response) {
    console.log("Richiesta ricevuta dal server");

    //response.write(request.url);

    var url_obj = url.parse(request.url, true);
    var query_params = url_obj.query;
    var path_name = url_obj.pathname;

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

    console.log(query_params);
    console.log(path_name);

    response.end();
}
http.createServer(onRequest).listen(SERVER_PORT);
console.log("Server avviato ed in ascolto sulla porta " + SERVER_PORT);



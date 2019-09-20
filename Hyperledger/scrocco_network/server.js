var http = require("http");
var cont = 0;

function onRequest(request, response) {
    console.log("Richiesta ricevuta dal server");


    response.writeHead(200, {"Content-Type": "text/plain"});
    response.write("Richiesta ricevuta");
    response.write("Chiamata n." + cont);
    cont++;

    console.log(request.post);

    response.end();
}
http.createServer(onRequest).listen(8080);
console.log("Server avviato");



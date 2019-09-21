$('#luogo-viaggio').hide();
$('#motivo-viaggio').hide();
$('#bot-answer').hide();

$('#selection-tipologia').click(function (e) {
    e.preventDefault();
    $('#luogo-viaggio').delay(2000).fadeIn(800);
    $('#motivo-viaggio').hide();
    $('#bot-answer').hide();
    $('#tipologia-viaggio').delay(2000).fadeOut(800); 

});

$('#selection-tipologia').change(function(){
    var tipologia = $('#selection-tipologia').val();
    console.log(tipologia);
});


$('#selection-luogo').click(function (e) {
    e.preventDefault();
    $('#luogo-viaggio').delay(2000).fadeOut(800);
    $('#motivo-viaggio').delay(2000).fadeIn(800);
    $('#bot-answer').hide();
    $('#tipologia-viaggio').hide(); 

});

$('#selection-luogo').change(function(){
    var luogo = $('#selection-luogo').val();
    console.log(luogo);
});

$('#selection-motivo').click(function (e) {
    e.preventDefault();
    $('#luogo-viaggio').hide();
    $('#motivo-viaggio').delay(2000).fadeOut(800);
    $('#bot-answer').delay(2000).fadeIn(800);
    $('#tipologia-viaggio').hide();

    chiamataViaggi();
});

$('#selection-motivo').change(function(){
    var motivo = $('#selection-motivo').val();
    console.log(motivo);
});

function chiamataViaggi(){

    function bot_success(json_response){
       
        console.log(json_response);
        let table;
        table = "<table>";
        table = table + "<tr><th><h1>Tipo</h1></th> <th><h1>Destinazioni</h1></th> <th><h1>Data</h1></th> <th><h1>Prezzo</h1></th> </tr>"
        $.each(json_response, function(index,value){

            let destinationString = '';

            $.each(value.destinations, function (index, destination) {
                destinationString = destinationString + destination + "<br>";
            });

            

            let newRaw = "<tr>";

            
            newRaw = newRaw + "<td>" + value.type + "</td>";
            newRaw = newRaw + "<td>" + destinationString + "</td>";
            newRaw = newRaw + "<td> Da <br>" + value.startdata+ "<br> a <br>" + value.finishdata + " </td>";
            newRaw = newRaw + "<td>" + value.price + "</td>";


            newRaw = newRaw + "</tr>";

            table = table + newRaw;
        });

        table = table + "</table>";

        $("#results-travel").html(table);
    }

    function bot_missing_parameter(json_response){
        alert("Errore nei parametri");
    }

    function bot_internal_server_error(json_response){
        alert("Internal server error");
    }

    let viaggio_dati ={
        type : $('#selection-tipologia').val()
    };

    let viaggio_functions = {
        200: bot_success,
        400: bot_missing_parameter,
        500: bot_internal_server_error
    };


    post("api/travel/travel_bot.php", viaggio_dati,viaggio_functions);


}

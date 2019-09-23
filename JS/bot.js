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
        $.each(json_response, function(index,travel){

            let destinationString = '';

            $.each(travel.destinations, function (index, destination) {
                destinationString = destinationString + destination + "<br>";
            });

            let newRow = "<tr>";
            newRow = newRow +  "<th>Tipo</th>";
            newRow = newRow + "<td>" + travel.type + "</td>";
            newRow = newRow + "<th>Destinazioni</th>"; 
            newRow = newRow + "<td>" + destinationString + "</td>";
            newRow = newRow + "<th>Data</th>";
            newRow = newRow + "<td> Da <br>" + travel.startdata+ "<br> a <br>" + travel.finishdata + " </td>";
            newRow += " <th>Prezzo</th>";
            newRow = newRow + "<td>" + travel.price + "<img src='IMG/scrocco.png' alt='moneta'></td>";
            newRow += " <th>Dettagli e prenota</th>";
            newRow = newRow + "<td><a href='dettaglio_prenotazione.htm?id=" + travel._id.$oid + "'><i class='far fa-calendar-check fa-2x'></i></a></td>";
            newRow = newRow + "</tr>";

            table = table + newRow;
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

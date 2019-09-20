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
        alert("Chiamata avvenuta con successo");
        console.log(json_response);
    }

    function bot_missing_parameter(json_response){
        alert("Errore nei parametri");
    }

    function bot_internal_server_error(json_response){
        alert("Internal server error");
    }
    let viaggio_dati ={

        type : $('#tipologia-viaggio').val()

    };
    let viaggio_functions = {
        200: bot_success,
        400: bot_missing_parameter,
        500: bot_internal_server_error
    };


    post("api/travel/travel_bot.php", viaggio_dati,viaggio_functions);


}

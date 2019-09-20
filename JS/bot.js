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

    //chiamata dentro una funzione
});

$('#selection-motivo').change(function(){
    var motivo = $('#selection-motivo').val();
    console.log(motivo);
});

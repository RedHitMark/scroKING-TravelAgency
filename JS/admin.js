
$( "#selection" ).click(function() {
    
});
$("#invia").click(function(){
    var type = $("#selection").val();
    var namenewelement = $("#namenewelement").val();
    var infonewelement = $("#infonewelement").val();
    $( "#report" ).html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'>Riepilogo informazioni inserite:</h1>" + "<br>" + "<b>Tipologia nuovo elemento: </b> " + type + "<br>" + "<b>Nome nuovo elemento: </b>" + namenewelement + "<br>" + "<b>Informazioni nuovo elemento:</b> " + infonewelement );
});

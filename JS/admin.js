$("#mezzi-panel").hide();
$("#hotels-panel").hide();


$( "#selection" ).click(function(e) {
    e.preventDefault();
    var type = $("#selection").val();
    if( type == "mezzi"){
        $("#mezzi-panel").show();
        $("#hotels-panel").hide();
    }else if( type == "hotel"){
        $("#hotels-panel").show();
        $("#mezzi-panel").hide();
    }else if (type == "null"){
        $("#mezzi-panel").hide();
        $("#hotels-panel").hide();
    }
});

$("#invia-riepilogo").click(function(){
    /* General*/
    var type = $("#selection").val();
    /* Mezzi */
    var postiMezzo = $("#posti-mezzo").val();
    var costoMezzo = $("#costo-mezzo").val();
    var tipologiaMezzo = $("#tipologia-mezzo").val();
    var nomeMezzo = $("#nome-mezzo").val();
    var descrizioneMezzo = $("#descrizione-mezzo").val();
    var trattaMezzo = $("#tratta-mezzo").val();
    /* Hotels */
    var nomeHotel = $('#nome-hotel').val();
    var descrizioneHotel = $('#descrizione-hotel').val();
    var indirizzoHotel = $('#indirizzo-hotel').val();
    var telefonoHotel = $('#telefono-hotel').val();
    var emailHotel = $('#email-hotel').val();
    var camerelibereHotel = $('#camerelibere-hotel').val();
    /* Report message and insert call */
    if (type == 'mezzi') {
        $( "#report" ).html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'>Riepilogo informazioni inserite:</h1>" + "<br>" + "<b>Tipologia nuovo elemento: </b> " + type + "<br>" + "<b>Posti del mezzo: </b>" + postiMezzo + "<br>" + "<b>Costo del mezzo:</b> " + costoMezzo + "<br>" + "<b>Tipologia del mezzo: </b>" + tipologiaMezzo + "<br>" + "<b>Nome del mezzo</b>" + nomeMezzo + "<br>" + "<b>Descrizione del mezzo</b>" + descrizioneMezzo + "<br>" + "<b>Tratta del mezzo</b>" + trattaMezzo );
    } else if( type == 'hotel') {
        $('#report').html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'>Riepilogo informazioni inserite:</h1>" + "<br>" + "<b>Tipologia nuovo elemento: </b> " + type + "<br>" + "<b>Nome hotel: </b>" + nomeHotel + "<br>" + "<b>Descrizione hotel: </b>" + descrizioneHotel + "<br>" + "<b>Indirizzo Hotel: </b>" + indirizzoHotel + "<br>" + "<b>Telefono hotel: </b>" + telefonoHotel + "<br>" + "<b>E-mail hotel: </b>" + emailHotel + "<br>" + "<b>Camere libere: </b>" + camerelibereHotel);
        insert_hotel()
    } else if(type == 'null') {
        $('#report').html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold; margin: 1em 0; color:red;'>Non sono state inserite informazioni</h1>");
    }
});

function insert_hotel() {
    function insert_ok() {
        alert("Inserimento avvenuto con successo");
    }

    function insert_bad_request() {
        alert("Compila tutti i campi")
    }

    function insert_internal_server_error() {
        alert("Riprova più tardi");
    }

    let functions = {
        200: insert_ok,
        400: insert_bad_request,
        500: insert_internal_server_error
    };

    let hotel_data = {
        name: $('#nome-hotel').val(),
        description: $('#descrizione-hotel').val(),
        address : {
            street : $('#indirizzo-hotel').val(),
            city : $('#citta-hotel').val(),
            cap : $('#cap-hotel').val(),
            region : $('#region-hotel').val(),
            state : $('#state-hotel').val()
        },
        phone : $('#telefono-hotel').val(),
        email : $('#email-hotel').val(),
        free_rooms : $('#camerelibere-hotel').val(),
    };

    console.log(hotel_data);

    post("api/hotel/insert_hotel.php", hotel_data, functions);
}

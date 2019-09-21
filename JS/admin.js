$("#mezzi-panel").hide();
$("#hotels-panel").hide();
$("#viaggi-panel").hide();


$("#selection").click(function (e) {
    e.preventDefault();
    var type = $("#selection").val();
    if (type == "mezzi") {
        $("#mezzi-panel").show();
        $("#hotels-panel").hide();
        $("#viaggi-panel").hide();
    } else if (type == "hotel") {
        $("#hotels-panel").show();
        $("#mezzi-panel").hide();
        $("#viaggi-panel").hide();
    } else if (type == "null") {
        $("#mezzi-panel").hide();
        $("#hotels-panel").hide();
        $("#viaggi-panel").hide();
    } else if (type == 'viaggi') {
        $("#viaggi-panel").show();
        $("#mezzi-panel").hide();
        $("#hotels-panel").hide();
    }
});


var numMezziInseriti = 0;


$('#button-mezzo-scelto').click(function () {
    if(numMezziInseriti <= 3){
        numMezziInseriti++;
        console.log(numMezziInseriti);
        var select = '<select id="mezzo-scelto' +  numMezziInseriti + '">';
        select += veicleselect;
        select += '</select>';
        $("#scelta-mezzi").append(select);
    }else {
        $("#scelta-mezzi").html("<b>Hai inserito troppi parametri</b>");
    }

});




var numHotelsInseriti = 0;

$('#button-hotel-scelto').click(function () {


    if(numHotelsInseriti <= 3){
        numHotelsInseriti++;
        console.log(numHotelsInseriti);
        var select = '<select id="hotel-scelto' +  numHotelsInseriti + '">';
        select += hotelselect;
        select += '</select>';
        $("#scelta-hotel").append(select);
    }else {
        $("#scelta-hotel").html("<b>Hai inserito troppi parametri</b>");
    }

});

var hotelscelto = $('#hotel-scelto').val();
var hotelscelto1 = $('#hotel-scelto1').val();
var hotelscelto2 = $('#hotel-scelto2').val();
var hotelscelto3 = $('#hotel-scelto3').val();

function cittaScelte(){
    var city1 = $('#city1').val();
    var city2 = $('#city2').val();
    var city3 = $('#city3').val();
    if( city2 == '' && city3 == ''){
        //console.log(city1);
        return city1;
    }else if(city3 == ''){
        console.log(city1, city2);
        var doublecities = city1 + " , " + city2;
        return doublecities;
    }else{
        console.log(city1, city2, city3);
        var triplecities = city1 + " , " + city2 + " , " + city3;
        return triplecities;
    }
}


function mezziScelti(){

    let mezziString = '';
    for (let index = 0; index <= numMezziInseriti; index++) {
        let id =  '#mezzo-scelto' + index;
        mezziString = mezziString + $(id).val() + ',';
    }

    mezziString = mezziString.substring(0, mezziString.length - 1);

    return mezziString;
}

function hotelScelti(){
    let hotelString = '';
    for (let index = 0; index <= numHotelsInseriti; index++) {
        let id =  '#hotel-scelto' + index;
        hotelString += $(id).val() + ',';
    }

    hotelString = hotelString.substring(0, hotelString.length - 1);

    return hotelString;
}


$("#invia-riepilogo").click(function () {
    /* General*/
    var type = $("#selection").val();
    /* Mezzi */
    var postiMezzo = $("#posti-mezzo").val();
    var costoMezzo = $("#costo-mezzo").val();
    var tipologiaMezzo = $("#tipologia-mezzo").val();
    var nomeMezzo = $("#nome-mezzo").val();
    var descrizioneMezzo = $("#descrizione-mezzo").val();

    /* Hotels */
    var nomeHotel = $('#nome-hotel').val();
    var descrizioneHotel = $('#descrizione-hotel').val();
    var indirizzoHotel = $('#indirizzo-hotel').val();
    var telefonoHotel = $('#telefono-hotel').val();
    var emailHotel = $('#email-hotel').val();
    var camerelibereHotel = $('#camerelibere-hotel').val();
    /* Viaggi */
    var tipologiaViaggio = $('#selection-viaggio').val();
    var dataAndata = $('#dataandata').val();
    var dataRitorno = $('#dataritorno').val();
    var prezzo = $('#prezzo').val();
    

    /* Report message and insert call */
    if (type == 'mezzi') {
        $("#report").html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'>Riepilogo informazioni inserite:</h1>" + "<br>" + "<b>Tipologia nuovo elemento: </b> " + type + "<br>" + "<b>Posti del mezzo: </b>" + postiMezzo + "<br>" + "<b>Costo del mezzo:</b> " + costoMezzo + "<br>" + "<b>Tipologia del mezzo: </b>" + tipologiaMezzo + "<br>" + "<b>Nome del mezzo</b>" + nomeMezzo + "<br>" + "<b>Descrizione del mezzo</b>" + descrizioneMezzo);

        insert_veicle();

    } else if (type == 'hotel') {
        $('#report').html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'>Riepilogo informazioni inserite:</h1>" + "<br>" + "<b>Tipologia nuovo elemento: </b> " + type + "<br>" + "<b>Nome hotel: </b>" + nomeHotel + "<br>" + "<b>Descrizione hotel: </b>" + descrizioneHotel + "<br>" + "<b>Indirizzo Hotel: </b>" + indirizzoHotel + "<br>" + "<b>Telefono hotel: </b>" + telefonoHotel + "<br>" + "<b>E-mail hotel: </b>" + emailHotel + "<br>" + "<b>Camere libere: </b>" + camerelibereHotel);
        insert_hotel()
    } else if (type == 'null') {
        $('#report').html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold; margin: 1em 0; color:red;'>Non sono state inserite informazioni</h1>");
    } else if (type == 'viaggi') {
        $('#report').html("<h1 style='text-transform: uppercase; text-align: center; font-weight: bold;'></h1>" + "<br>" + "<b>Tipologia viaggio: </b>" + tipologiaViaggio + "<br>" + "<b>Data andata: </b>" + dataAndata + "<br>" + "<b>Data ritorno: </b>" + dataRitorno + "<br>" + "<b>Prezzo: </b>" + prezzo + "<br>" + "<b>Città scelte: </b>" + cittaScelte() + "<br>" + "<b>Mezzi scelti: </b>" + mezziScelti() + "<br>" + "<b>Hotel scelti: </b>" + hotelScelti());
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
        address: {
            street: $('#indirizzo-hotel').val(),
            city: $('#citta-hotel').val(),
            cap: $('#cap-hotel').val(),
            region: $('#region-hotel').val(),
            state: $('#state-hotel').val()
        },
        phone: $('#telefono-hotel').val(),
        email: $('#email-hotel').val(),
        free_rooms: $('#camerelibere-hotel').val(),
    };

    console.log(hotel_data);

    post("api/hotel/insert_hotel.php", hotel_data, functions);
}

function insert_veicle() {

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

    let veicle_data = {
        name: $("#nome-mezzo").val(),
        description: $("#descrizione-mezzo").val(),
        type: $("#tipologia-mezzo").val(),
        seats: $("#posti-mezzo").val(),
        price: $("#costo-mezzo").val()
    }

    post("api/veicle/insert_veicle.php", veicle_data, functions);
}


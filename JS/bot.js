$('.placesButtons').hide();
$('.kindsButtons').hide();
$('.botanswer').hide();



$('.countryButtons, button').click(function(e){
    e.preventDefault();
    $('.kindsButtons').hide();
    $('.countryButtons').hide();
    $('.placesButtons').show();
    $('.botanswer').hide();
});

$('.placesButtons, button').click(function(e){
    e.preventDefault();
    $('.kindsButtons').show();
    $('.countryButtons').hide();
    $('.placesButtons').hide();
    $('.botanswer').hide();
});

$('.kindsButtons, button').click(function(e){
    e.preventDefault();
    $('.kindsButtons').hide();
    $('.countryButtons').hide();
    $('.placesButtons').hide();
    $('.botanswer').show();
});

/* selection each dates to make query */


$( "#countryB button" ).click(function() {
    var country = $(this).text();
    console.log(country);
});
$( "#placesB button" ).click(function() {
    var place = $(this).text();
    console.log(place);
});
$( "#kindsB button" ).click(function() {
    var kind = $(this).text();
    console.log(kind);
});



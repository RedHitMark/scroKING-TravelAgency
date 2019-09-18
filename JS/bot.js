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




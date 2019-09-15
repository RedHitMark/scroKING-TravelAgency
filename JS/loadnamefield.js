$('.scrollname').hide();
let visiblenamefield = false;
$('#modifyusername').click(function(e){

    e.preventDefault();
    $('.scrollname').toggle("slow");

});

$('#confirmnewusrname').click(function(e){

    e.preventDefault();
    $('.scrollname').hide("slow");

});


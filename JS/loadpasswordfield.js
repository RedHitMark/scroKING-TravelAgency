$('.scrollpassword').hide();
let visiblefield =  false;
$('#morePassword').click(function(e){
    e.preventDefault();
    $('.scrollpassword').toggle("slow");

});

$('#confirmpassword').click(function(e){
    e.preventDefault();
    $(".scrollpassword").hide("slow");

});

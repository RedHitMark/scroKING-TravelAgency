$('.scrollpassword').hide();
let visiblefield =  false;


$('#modifypassword').click(function(e){
    e.preventDefault();

    $('.scrollpassword').toggle("slow");
});


$('#confirmpassword').click(function(e){
    e.preventDefault();

    $(".scrollpassword").hide("slow");
});


$('#resetpssform').click(function(e){
    e.preventDefault();

    $(".scrollpassword").hide("slow");
});

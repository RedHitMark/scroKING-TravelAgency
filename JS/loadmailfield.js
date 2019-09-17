$('.scrollmail').hide();

$('#modifymail').click(function(e){
    e.preventDefault();

    $('.scrollmail').toggle("slow");
});

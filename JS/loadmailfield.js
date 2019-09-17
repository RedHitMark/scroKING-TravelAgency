$('.scrollmail').hide();
let visiblefieldemail = false;
$('#modifymail').click(function(e){
    e.preventDefault();

    $('.scrollmail').toggle("slow");
});

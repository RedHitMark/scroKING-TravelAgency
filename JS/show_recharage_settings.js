$('#rechargesettings').hide();
let visiblerecharge = false;
$('.recarghe').click(function(e){
    e.preventDefault();

    $('#rechargesettings').toggle("slow");
});

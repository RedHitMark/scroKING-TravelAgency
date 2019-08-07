
$('.scroll').hide();
let visible = false;
$('#moreButton').click(function (e) {
    e.preventDefault();
    $('.scroll').toggle("slow");
    if (visible == false) {
        $("#moreButton").prop('value', 'Mostra meno risultati');

        visible = true;
    } else if (visible == true) {
        $("#moreButton").prop('value', 'Mostra altri risultati');
        visible = false;
    }
});
$('#usersettings').hide();
let visiblesettings = false;
$('.cog').click(function(e){
    e.preventDefault();

    $('#usersettings').toggle("slow");
});
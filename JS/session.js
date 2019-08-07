//include jquery files
var imported = document.createElement('script');
imported.src = 'JS/jquery.min.js';
document.head.appendChild(imported);

$('#user').hide();
let visibleUser = false;
$('#entra').click(function(e){
    e.preventDefault();
    if(visibleUser == false){
        $('#user').prop('value', "<h1>Hello, <?php echo ( $_SESSION['username']) ?> </h1>");
    }
});
/* user page */
$('#wallet').hide();
let visibleHistory = true;
let visibleWallet = false;

$('.booking').click(function(e)
{
    
    if(visibleHistory){
        $('#prenotazionihistory').hide();
        visibleHistory =false;
    } else if(!visibleHistory) {
        $('#prenotazionihistory').show("slow");
        $('#wallet').hide();
        visibleHistory = true;
        visibleWallet = false;
    }

}); 
$('.portafoglio').click(function(e)
{
    
    if(visibleWallet){
        $('#wallet').hide("slow");

        visibleWallet = false;
    } else if(!visibleWallet) {
        $('#wallet').show("slow");
        $('#prenotazionihistory').hide();
        visibleWallet = true;
        visibleHistory = false;
    }

}); 

/* user page */
// $('.previus-trips p').hide();
// let visible = false;
// $('.previus-trips h3').click(function (e) {
//     e.preventDefault();
//     $('.previus-trips p').toggle("slow");
//     if (visible == false) {
//         var collapsed=$(this).find('i').hasClass('fas fa-angle-down');
    
//     $('.faq-links').find('i').removeClass('fas fa-angle-down');
    
//     $('.faq-links').find('i').addClass('fas fa-arrow-up');
//     if(collapsed)
//     $(this).find('i').toggleClass('fas fa-angle-down fas fa-angle-up');

//         visible = true;
//     } else if (visible == true) {
//         var collapsed=$(this).find('i').hasClass('fas fa-angle-up');
    
//     $('.faq-links').find('i').removeClass('fas fa-angle-up');
    
//     $('.faq-links').find('i').addClass('fas fa-angle-down');
//     if(collapsed)
//     $(this).find('i').toggleClass('fas fa-angle-up fas fa-angle-down');
//     visible = false;
//     }
    
// });
    
$('#wallet').hide();
let visible = false;
let visibleWallet = false;
$('.booking').click(function(e)
{
    
    if(visible == true){
        $('#prenotazionihistory').toggle("slow");
        visible =false;
    
    }else if(visible == false)
    {
        $('#prenotazionihistory').hide();
        visible = true;
    }

}); 
$('.portafoglio').click(function(e)
{
    
    if(visibleWallet == true){
        $('#wallet').toggle("slow");
        visibleWallet =false;
    
    }else if(visibleWallet == false)
    {
        $('#wallet').hide();
        visibleWallet = true;
    }

}); 
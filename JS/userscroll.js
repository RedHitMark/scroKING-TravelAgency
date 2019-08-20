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
    
$('.tableprenotazioni').hide();
let visible = false;
$('.tableprenotazioni').click(function(e)
{
    
    if(visible == true){
        $('.tabellaprenotazioni').toggle("slow");
        visible =false;
    
    }else if(visible == false)
    {
        $('.tabellaprenotazioni').hide();
        visible = true;
    }

}); 
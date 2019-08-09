/* user page */
$('.previus-trips p').hide();
let visible = false;
$('.previus-trips h3').click(function (e) {
    e.preventDefault();
    $('.previus-trips p').toggle("slow");
    if (visible == false) {
        var collapsed=$(this).find('i').hasClass('fas fa-arrow-down');
    
    $('.faq-links').find('i').removeClass('fas fa-arrow-down');
    
    $('.faq-links').find('i').addClass('fas fa-arrow-up');
    if(collapsed)
    $(this).find('i').toggleClass('fas fa-arrow-down fas fa-arrow-up');

        visible = true;
    } else if (visible == true) {
        var collapsed=$(this).find('i').hasClass('fas fa-arrow-up');
    
    $('.faq-links').find('i').removeClass('fas fa-arrow-up');
    
    $('.faq-links').find('i').addClass('fas fa-arrow-down');
    if(collapsed)
    $(this).find('i').toggleClass('fas fa-arrow-up fas fa-arrow-down');
    visible = false;
    }
});
    
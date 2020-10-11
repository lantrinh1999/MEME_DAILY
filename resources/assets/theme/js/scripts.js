$(document).ready(function() {
    //////////////////////
    var meunu_height = $('.header').height();

    function fixed_menu() {
        // let height = ;
        $('.header').addClass('fixed-top');
        $('.main').css({ 'margin-top': meunu_height + 'px' });
    }
    fixed_menu();
    if (!isMobile()) {
        let a = new StickySidebar('#sidebar', {
            topSpacing: 20 + meunu_height,
            bottomSpacing: 20,
            containerSelector: '.row',
            innerWrapperSelector: '.sidebar__inner'
        });
    }



    //////////////////////
});
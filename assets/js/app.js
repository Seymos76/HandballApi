console.log('app is ok');
const $ = require('jquery');
$(function () {
    const menu_toggle = $("#menu_toggle");
    const menu_icon = $("#menu_toggle i.fa");
    const overlay_menu = $(".main__navigation__overlay");
    menu_toggle.click(function () {
        if (overlay_menu.hasClass('active')) {
            menu_icon.removeClass('fa-times');
            menu_icon.addClass('fa-bars');
            overlay_menu.removeClass('active');
        } else {
            console.log('menu displayed');
            overlay_menu.addClass('active');
            menu_icon.removeClass('fa-bars');
            menu_icon.addClass('fa-times');
        }
    });
});
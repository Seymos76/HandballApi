const $ = require('jquery');
$( document ).ready(function() {
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
    let timers = $(".next__match__timer");
    let now = new Date();
    let targetDate = timers[0].dataset.timer;
    //console.log(targetDate);
    let targetDay = targetDate.slice(0,2);
    let targetMonth = targetDate.slice(3,5);
    let targetYear = targetDate.slice(6,targetDate.length);
    /*console.log(targetDay);
    console.log(targetMonth);
    console.log(targetYear);*/
    let formattedTargetDate = new Date(targetMonth+"/"+targetDay+"/"+targetYear);
    let distance = formattedTargetDate - now;
    /*console.log("Date cible");
    console.log(formattedTargetDate);
    console.log("Aujourd'hui");
    console.log(now);*/

    $.each(timers, function (key, timer) {
        let targetDate = timer.dataset.timer;
        let timer_id = timer.dataset.id;
        setInterval(function () {
            let now = new Date();
            let formattedTargetDate = new Date(targetDate);
            let distance = formattedTargetDate - now;
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            $(".timer__days__"+timer_id).text(days);
            $(".timer__hours__"+timer_id).text(hours);
            $(".timer__minutes__"+timer_id).text(minutes);
            $(".timer__seconds__"+timer_id).text(seconds);
        }, 1000);
    });
});
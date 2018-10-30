$( document ).ready(function() {
    setInterval(function time(){
        let d = new Date();
        let hours = 24 - d.getHours();
        let min = 60 - d.getMinutes();
        if((min + '').length == 1){
            min = '0' + min;
        }
        let sec = 60 - d.getSeconds();
        if((sec + '').length == 1){
            sec = '0' + sec;
        }
        jQuery('#countdown #hour').html(hours);
        jQuery('#countdown #min').html(min);
        jQuery('#countdown #sec').html(sec);
    }, 1000); 
});
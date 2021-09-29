// Gestion du bouton Voir les Episodes qui se Replier
$('.cacher, .voir').click(function(){

    $(this).text(function(i,old){

        if ($(this).hasClass('voir'))
        {
            $(this).toggleClass('cacher').toggleClass('voir');
            return 'Replier';
        }
        else if ($(this).hasClass('cacher'))
        {
            $(this).toggleClass('voir').toggleClass('cacher'); 
            return 'Voir les Episodes';
        }
        
    });

});
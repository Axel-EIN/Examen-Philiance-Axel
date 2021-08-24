$('.cacher, .voir').click(function(){
    $(this).text(function(i,old){
        let idEpisodes = $(this).parent().parent().prev().attr('id');
        let idChapitre = $(this).parents().eq(4).attr('id');
        if (old=='Voir les Episodes')
        {
            $(this).toggleClass('cacher').toggleClass('voir');
            $(this).parent().attr("href","#" + idEpisodes);
            $(this).parents().eq(4).toggleClass('fermer');
            return 'X';
        }
        else if (old=='X')
        {
            $(this).toggleClass('cacher').toggleClass('voir'); 
            $(this).parent().attr("href","#" + idChapitre);
            $(this).parents().eq(4).toggleClass('fermer');
            return 'Voir les Episodes';
        }
    });
});
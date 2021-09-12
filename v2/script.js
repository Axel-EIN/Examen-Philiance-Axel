// Gestion du bouton Voir les Episodes qui se transofrme en X
$('.cacher, .voir').click(function(){
    $(this).text(function(i,old){
        let AncreLectureEpisodes = $(this).parents().eq(2).find('.lead').attr('id');
        let AncreLectureChapitre = $(this).parents().eq(4).attr('id');
        if (old=='Voir les Episodes')
        {
            $(this).toggleClass('cacher').toggleClass('voir');
            $(this).parent().attr("href",'#' + AncreLectureEpisodes);
            $(this).parents().eq(5).toggleClass('fermer');
            return 'Replier';
        }
        else if (old=='Replier')
        {
            $(this).toggleClass('cacher').toggleClass('voir'); 
            $(this).parent().attr("href","#" + AncreLectureChapitre);
            $(this).parents().eq(5).toggleClass('fermer');
            return 'Voir les Episodes';
        }
    });
});
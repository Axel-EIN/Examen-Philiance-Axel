<?php

class Participation extends SimpleOrm {
    public $id;
    public $scene_id;
    public $personnage_id;
    public $exp_gagne;
    public $est_mort;
}

function recuperer_participants_par_scene($id_scene): array {
    // Renvoi les données de tout les personnages participants qui ont participés à la scène

    $participations = Participation::retrieveByField('scene_id',$id_scene, SimpleOrm::FETCH_MANY, SimpleOrm::options('exp_gagne', SimpleOrm::ORDER_ASC));
    if ($participations === null)
        redirection('500', 'Désolé ! Il n\'a pas de participations à cette scène');

    require_once DOSSIER_MODELS . '/Personnage.php';
    $personnages_trouves = [];
    foreach($participations as $une_participation) {
        $personnages_trouves[] = personnage_trouve_par_id($une_participation->personnage_id);
    }

    return $personnages_trouves;
}
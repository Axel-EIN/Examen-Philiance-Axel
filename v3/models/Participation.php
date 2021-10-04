<?php

class Participation extends SimpleOrm {
    public $id;
    public $scene_id;
    public $personnage_id;
    public $exp_gagne;
    public $est_mort;
}

// RETRIEVES PARTICIPATIONS

function recuperer_une_participation(int $id_participation): object {
    // Trouve une ligne de participation via l'ID puis renvoi toutes les données sous forme d'un objet

    return Participation::retrieveByField('id', $id_participation, SimpleOrm::FETCH_ONE);
}

// RETRIEVES VIA UNE SCENE, UN EPISODE et/ou PERSONNAGE

function recuperer_une_participation_via_personnage_scene(int $id_personnage, int $id_scene): object {
	// Renvoi la ligne de participation d'un personnage dans une scène ou bien false

    $participations_de_la_scene = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY);

    if (!empty($participations_de_la_scene)) {

        foreach($participations_de_la_scene as $une_participation)
            if($une_participation->personnage_id == $id_personnage) {
                $ligne_de_participation = Participation::retrieveByField('id', $une_participation->id, SimpleOrm::FETCH_ONE);
                if($ligne_de_participation !== null)
                    return $ligne_de_participation;
            }     

    }

    return null;
}

function recuperer_participations($id_scene): array {
	// Renvoi les lignes de participation des personnage dans une scène
    return Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY);
}

function recuperer_participations_pjs($id_scene): array {
    // Renvoi les données de tout les participations JOUEURS dans une scène

    $participations = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY, SimpleOrm::options('exp_gagne', SimpleOrm::ORDER_DESC));

    require_once DOSSIER_MODELS . '/Personnage.php';
    $participations_pjs = [];
    foreach($participations as $une_participation) {
        if (recuperer_un_personnage($une_participation->personnage_id)->est_pj == 1)
            $participations_pjs[] = $une_participation;
    }

    return $participations_pjs;    
}

function recuperer_participations_pnjs($id_scene): array {
    // Renvoi les données de tout les participations NON-JOUEURS dans une scène

    $participations = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY);

    require_once DOSSIER_MODELS . '/Personnage.php';
    $participations_pnjs = [];
    foreach($participations as $une_participation) {
        if (recuperer_un_personnage($une_participation->personnage_id)->est_pj == 0)
            $participations_pnjs[] = $une_participation;
    }

    return $participations_pnjs;    
}

function recuperer_participations_via_episodes(int $id_episode): array {
    require_once DOSSIER_MODELS . '/Scene.php';
    $scenes_trouvees = scenes_enfants_de_episode_triees_numero($id_episode);
    
    $toutes_les_participations = [];
    foreach($scenes_trouvees as $une_scene_trouvee)
        $toutes_les_participations = array_merge($toutes_les_participations, recuperer_participations($une_scene_trouvee->id));

    $participations_episode = [];

    foreach($toutes_les_participations as $une_participation) {
        $trouvee = false;
        if(!empty($participations_episode)) {
            foreach($participations_episode as $une_participation_episode) {
                if ($une_participation->personnage_id == $une_participation_episode->personnage_id) {
                    $trouvee = true;
                    $une_participation_episode->exp_gagne += $une_participation->exp_gagne;
                }
            }
        }

        if ($trouvee == false)
            $participations_episode[] = $une_participation;
    }
    return $participations_episode;
}

// CRUD PARTICIPATIONS

function ajouter_une_participation(int $id_scene, int $id_participant, int $xp = 0, int $mort = 0) {
    // Cette fonction ajoute un participant à une scène et renvoi le dernier ID inséré dans la table ou false

    require_once DOSSIER_MODELS . '/Personnage.php';
    if ( !empty(recuperer_un_personnage($id_participant))
        && !empty(scene_trouve_par_id($id_scene)) ) {
        $nouvelle_participation = new Participation;
        $nouvelle_participation->scene_id = $id_scene;
        $nouvelle_participation->personnage_id = $id_participant;
        $nouvelle_participation->exp_gagne = $xp;
        $nouvelle_participation->est_mort = $mort;
        $nouvelle_participation->save();
        return $nouvelle_participation->id;
    } else
        return false;
}

function modifier_une_participation_xp_mort(object $participation_trouvee, int $xp = 0, int $mort = 0): bool {
    // Cette fonction modifie l'experience gagne ou l'evenement mort d'un participant dans une scène

    $participation_trouvee->exp_gagne = $xp;
    $participation_trouvee->est_mort = $mort;
    $participation_trouvee->save();

    return true;
}

function supprimer_une_participation_via_personnage_scene(int $id_personnage, int $id_scene): bool {
    // Cette fonction supprime une participation d'un personnage dans une scène

    $participations = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY);

    if(!empty($participations)) {

        foreach($participations as $une_participation) {
            if($une_participation->personnage_id == $id_personnage) {
                $une_participation->delete();
                return true;
            }
        }

    }

    return false;
}
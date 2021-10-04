<?php

class Personnage extends SimpleOrm {
    public $id;
    public $nom;
    public $prenom;
    public $titres;
    public $icone;
    public $illustration;
    public $description;
    public $est_pj;
    public $clan_id;
    public $classe_id;
    public $ecole_id;
    public $utilisateur_id;
}

function recuperer_un_personnage($id_personnage): object {
	// Renvoi les données d'un personnage trouvé par son ID en objet

	$personnage_trouve = Personnage::retrieveByField('id', $id_personnage, SimpleOrm::FETCH_ONE);
    if ($personnage_trouve === null)
        redirection('500', 'Désolé ! Ce personnage n\'existe pas !');

	return $personnage_trouve;
}

function recuperer_un_personnage_par_prenom($prenom): object {
	// Renvoi les données d'un personnage trouvé par prenom  en objet

	$personnage_trouve = Personnage::retrieveByField('prenom', $prenom, SimpleOrm::FETCH_ONE);
    if ($personnage_trouve === null) {
        // redirection('500', 'Désolé ! Ce personnage n\'existe pas !');
        return false;
    }

	return $personnage_trouve;
}

function recuperer_pjs(): array {
    // Renvoi les données de tout les personnages qui sont ou ont été joués par des joueurs

    $pjs = Personnage::retrieveByField('est_pj',1, SimpleOrm::FETCH_MANY, SimpleOrm::options('clan_id', SimpleOrm::ORDER_ASC));
    if ($pjs === null)
        redirection('500', 'Désolé ! Il n\'a pas encore de personnage joueurs disponible');

    return $pjs;
}

function recuperer_pnjs(): array {
    // Renvoi les données de tout les personnages qui sont joués par le Maître du Jeu

    $pnjs = Personnage::retrieveByField('est_pj',0, SimpleOrm::FETCH_MANY, SimpleOrm::options('clan_id', SimpleOrm::ORDER_ASC));
    if ($pnjs === null)
        redirection('500', 'Désolé ! Il n\'a pas encore de personnage non-joueurs disponible');

    return $pnjs;
}

function recuperer_personnages_de_utilisateur(int $id_utilisateur): array {
    return Personnage::retrieveByField('utilisateur_id', $id_utilisateur, SimpleOrm::FETCH_MANY);
}

// RETRIEVE PERSONNAGES PAR PARTICIPATION SCENE
require_once DOSSIER_MODELS . '/Participation.php';

function recuperer_personnages_par_scene(int $id_scene): array {
    // Renvoi les données de tout les personnages participants qui ont participés à la scène

    $participations = Participation::retrieveByField('scene_id',$id_scene, SimpleOrm::FETCH_MANY, SimpleOrm::options('exp_gagne', SimpleOrm::ORDER_ASC));

    $personnages_trouves = [];
    foreach($participations as $une_participation) {
        $personnages_trouves[] = recuperer_un_personnage($une_participation->personnage_id);
    }

    return $personnages_trouves;
}

function recuperer_pjs_par_scene(int $id_scene): array {
    // Renvoi les données de tout les personnages JOUEURS participants qui ont participés à la scène

    $participations = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY, SimpleOrm::options('exp_gagne', SimpleOrm::ORDER_ASC));
    if ($participations === null)
        redirection('500', 'Désolé ! Il n\'a pas de participations à cette scène');

    $personnages_trouves = [];
    foreach($participations as $une_participation) {
        if (recuperer_un_personnage($une_participation->personnage_id)->est_pj == 1)
            $personnages_trouves[] = recuperer_un_personnage($une_participation->personnage_id);
    }

    return $personnages_trouves;
}

function recuperer_pnjs_par_scene(int $id_scene): array {
    // Renvoi les données de tout les personnages NON-JOUEURS qui ont participés à la scène

    $participations = Participation::retrieveByField('scene_id', $id_scene, SimpleOrm::FETCH_MANY, SimpleOrm::options('exp_gagne', SimpleOrm::ORDER_ASC));
    if ($participations === null)
        redirection('500', 'Désolé ! Il n\'a pas de participations à cette scène');

    $personnages_trouves = [];
    foreach($participations as $une_participation) {
        if (recuperer_un_personnage($une_participation->personnage_id)->est_pj == 0)
            $personnages_trouves[] = recuperer_un_personnage($une_participation->personnage_id);
    }

    return $personnages_trouves;
}

// TRAITEMENTS VIA PARTICIPATIONS

function somme_xp_participations_personnage(int $id_personnage): int {
    $participations = Participation::retrieveByField('personnage_id', $id_personnage, SimpleOrm::FETCH_MANY);
    
    $somme_xp = 0;
    foreach($participations as $une_participation)
        $somme_xp += $une_participation->exp_gagne;

    return $somme_xp;
}
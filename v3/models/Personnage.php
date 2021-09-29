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

function personnage_trouve_par_id($id): object {
	// Renvoi les données d'un personnage trouvé par ID en objet

	$personnage_trouve = Personnage::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($personnage_trouve === null)
        redirection('500', 'Désolé ! Ce personnage n\'existe pas !');

	return $personnage_trouve;
}

function tout_les_personnages_joueurs(): array {
    // Renvoi les données de tout les personnages qui sont ou ont été joués par des joueurs

    $pjs = Personnage::retrieveByField('est_pj',1, SimpleOrm::FETCH_MANY, SimpleOrm::options('clan_id', SimpleOrm::ORDER_ASC));
    if ($pjs === null)
        redirection('500', 'Désolé ! Il n\'a pas encore de personnage joueurs disponible');

    return $pjs;
}

function tout_les_personnages_non_joueurs(): array {
    // Renvoi les données de tout les personnages qui sont joués par le Maître du Jeu

    $pnjs = Personnage::retrieveByField('est_pj',0, SimpleOrm::FETCH_MANY, SimpleOrm::options('clan_id', SimpleOrm::ORDER_ASC));
    if ($pnjs === null)
        redirection('500', 'Désolé ! Il n\'a pas encore de personnage non-joueurs disponible');

    return $pnjs;
}
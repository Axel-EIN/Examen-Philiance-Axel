<?php

class Clan extends SimpleOrm {
    public $id;
    public $nom;
    public $mon;
    public $est_majeur;
    public $couleur;
    public $champion_id;
}

function clan_trouve_par_id($id): object {
	// Renvoi les données d'un clan trouvé par ID en objet

	$clan_trouve = Clan::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($clan_trouve === null)
        redirection('500', 'Désolé ! Ce clan n\'existe pas !');

	return $clan_trouve;
}

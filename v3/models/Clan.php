<?php

class Clan extends SimpleOrm {
    public $id;
    public $nom;
    public $mon;
    public $est_majeur;
    public $couleur;
    public $champion_id;
}

function recuperer_un_clan(int $id_clan): object {
	// Trouve les données d'un clan par son ID et les renvoi en objet

	$clan_trouve = Clan::retrieveByField('id', $id_clan, SimpleOrm::FETCH_ONE);
    if ($clan_trouve === null)
        redirection('500', 'Désolé ! Ce clan n\'existe pas !');

	return $clan_trouve;
}

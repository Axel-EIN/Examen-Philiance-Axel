<?php

class Saison extends SimpleOrm {
	public $id;
	public $numero;
	public $titre;
    public $image;
	public $couleur;
}

function saison_trouve_par_id($id): object {
	// Renvoi les données de la Saison parent en objet
	
	$saison_trouve = Saison::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($saison_trouve === null)
        redirection('500', 'Désolé ! Cette saison n\'existe pas !');

	return $saison_trouve;
}

function toutes_les_saisons(): array {
	// Renvoi toute les saisons en tableau d'objet

	$toute_les_saisons = Saison::all();
	if ($toute_les_saisons === null)
		redirection('500', 'Désolé ! Aucune saison n\est disponible !');

	return $toute_les_saisons;
}
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
        redirection('500', 'Erreur Interne!');

	return $saison_trouve;
}
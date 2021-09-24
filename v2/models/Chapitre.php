<?php

class Chapitre extends SimpleOrm {
	public $id;
	public $numero;
	public $titre;
	public $citation;
    public $image;
	public $couleur;
	public $id_saison;
	public $id_mj;
}

function chapitre_trouve_par_id($id): object {
	// Renvoi en objet les données du Chapitre

	$chapitre_trouve = Chapitre::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($chapitre_trouve === null)
		redirection('500', 'Désolé ! Ce chapitre n\'existe pas !');

	return $chapitre_trouve;
}

function chapitres_enfants_de_saison($saison_id): array {
	// Renvoi un tableau d'objet des chapitres d'une saison

	$chapitres_enfants = Chapitre::retrieveByField('id_saison', $saison_id, SimpleOrm::FETCH_MANY);
	if ($chapitres_enfants === null)
		redirection('500', 'Désolé ! Cette saison n\'a pas encore de chapitre enfant !');

	return $chapitres_enfants;
}

function chapitres_enfants_de_saison_tries_numero($saison_id): array {
	// Renvoi un tableau d'objet des chapitres d'une saison triés par numero

	$chapitres_enfants = Chapitre::retrieveByField(	'id_saison',
													$saison_id,
													SimpleOrm::FETCH_MANY,
													SimpleOrm::options('numero',SimpleOrm::ORDER_ASC));

	if ($chapitres_enfants === null)
		redirection('500', 'Désolé ! Cette saison n\'a pas encore de chapitre enfant !');

	return $chapitres_enfants;
}
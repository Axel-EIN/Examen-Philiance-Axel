<?php

class Episode extends SimpleOrm {
	public $id;
	public $numero;
	public $titre;
	public $resume;
    public $image;
	public $id_chapitre;
	public $id_saison;
}

function episode_trouve_par_id($id): object {
	// Renvoi en objet les données de l'épisode
	
	$episode_trouve = Episode::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($episode_trouve === null)
        redirection('500', 'Erreur Interne au serveur!');

	return $episode_trouve;
}

function episodes_enfants_du_chapitre($chapitre_id): array {
	// Renvoi un tableau d'objet comprenant les episodes enfants

	$episodes_enfants = Episode::retrieveByField('id_chapitre', $chapitre_id, SimpleOrm::FETCH_MANY);
	if ($episodes_enfants === null)
		redirection('500', 'Ce Chapitre n\' a pas encore d\'episodes!');

	return $episodes_enfants;
}

function episodes_enfants_du_chapitre_triees_numero($chapitre_id): array {
	// Renvoi un tableau d'objet des episodes enfants d'un chapitre triés par numero

	$episodes_enfants = Episode::retrieveByField('id_chapitre',
												$chapitre_id,
												SimpleOrm::FETCH_MANY,
												SimpleOrm::options('numero',SimpleOrm::ORDER_ASC));
	if ($episodes_enfants === null)
		redirection('500', 'Ce Chapitre n\' a pas encore d\'episodes!');

	return $episodes_enfants;
}
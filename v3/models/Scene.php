<?php

class Scene extends SimpleOrm {
	public $id;
	public $numero;
	public $titre;
	public $temps;
    public $texte;
    public $image;
	public $id_episode;
}

function scene_trouve_par_id($id) {
	// Renvoi les données de la scène trouvé par ID en objet

	$scene_trouve = Scene::retrieveByField('id', $id, SimpleOrm::FETCH_ONE);
    if ($scene_trouve === null)
		redirection('500', 'Désolé ! Cette scène n\'existe pas !');

	return $scene_trouve;
}

function scenes_enfants_de_episode($episode_id): array {
	// Renvoi dans un tableau toutes les scenes enfants d'un épisode

	$scenes_enfants = Scene::retrieveByField('id_episode', $episode_id, SimpleOrm::FETCH_MANY);
	if ($scenes_enfants === null)
		redirection('500', 'Désolé ! Cette épisode n\'a pas encore de scène enfant !');

	return $scenes_enfants;
}

function scenes_enfants_de_episode_triees_numero($episode_id): array {
	// Cette fonction renvoie les scènes enfants d'un episode parent triées par leur numéro

	$scenes_enfants = Scene::retrieveByField(
												'id_episode',
												$episode_id,
												SimpleOrm::FETCH_MANY,
												SimpleOrm::options('numero', SimpleOrm::ORDER_ASC)
											);
	if ($scenes_enfants === null)
		redirection('500', 'Désolé ! Cette épisode n\'a pas encore de scène enfant !');

	return $scenes_enfants;
}
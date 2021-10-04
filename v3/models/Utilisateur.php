<?php

class Utilisateur extends SimpleOrm {
    public $id;
    public $identifiant;
    public $email;
    public $mdp;
    public $prenom;
    public $role;
    public $image;
}

function recuperer_un_utilisateur($id_utilisateur): object {
	// Renvoi les données de l'utilisateur trouvé par ID en objet

	$utilisateur_trouve = Utilisateur::retrieveByField('id', $id_utilisateur, SimpleOrm::FETCH_ONE);
    if ($utilisateur_trouve === null)
        redirection('500', 'Désolé ! Erreur interne au serveur !');

	return $utilisateur_trouve;
}

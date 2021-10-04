<?php

function afficher_aventure() {
    // Ce contrôlleur construit  la page Aventure

    // VERIFICATION des paramètres d'URL pour spécifier la saison
    if (!empty($_GET['saison']) && is_numeric($_GET['saison']) && $_GET['saison'] > 0)
        $numero_saison_courante = $_GET['saison'];
    else
        $numero_saison_courante = 1;

    // RECUPERATION des données pour la saison
    require_once DOSSIER_MODELS . '/Saison.php';
    $saison_trouve = Saison::retrieveByField('numero', $numero_saison_courante, SimpleOrm::FETCH_ONE);
    if ($saison_trouve == null) redirection('404', 'Désolé ! Cette saison n\'existe pas !');

    // RECUPERATION de toutes les saisons
    $saisons = Saison::all(SimpleOrm::options('numero', SimpleOrm::ORDER_ASC));

    // GESTION des Saisons précédentes ou Suivante
    $position_cle_saison = array_search($saison_trouve, $saisons);

    if (!empty($saisons[$position_cle_saison-1]))
        $saison_precedente = $saisons[$position_cle_saison-1];
    
    if (!empty($saisons[$position_cle_saison+1]))
        $saison_suivante = $saisons[$position_cle_saison+1];

    // RECUPERATION des données pour les Chapitres de la Saison
    require_once DOSSIER_MODELS . '/Chapitre.php';
    $chapitres = chapitres_enfants_de_saison_tries_numero($saison_trouve->id);

    // AFFICHAGE
    require_once DOSSIER_MODELS . '/Episode.php';
    $html_title = $saison_trouve->titre . ' (Saison ' . $saison_trouve->numero . ') | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/aventure/aventure.html.php';
}

function afficher_episode() {

    // Vérification des paramètres d'URL
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('404','Informations pour trouver l\'épisode invalides ou manquantes !');

    // Récupération des données
    require_once DOSSIER_MODELS . '/Episode.php';
    $episode_trouve = Episode::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($episode_trouve === null) redirection ('404','Désolé ! Cette épisode n\'existe pas !');

    require_once DOSSIER_MODELS . '/Chapitre.php';
    $chapitre_parent = Chapitre::retrieveByField('id', $episode_trouve->id_chapitre, SimpleOrm::FETCH_ONE);
    if ($chapitre_parent === null)
        redirection('404', 'Cette episode a un Chapitre parent manquant, incorrect ou invalide !');

    require_once DOSSIER_MODELS . '/Saison.php';
    $saison_parent = Saison::retrieveByField('id', $episode_trouve->id_saison, SimpleOrm::FETCH_ONE);
    if ($saison_parent === null)
        redirection('404', 'Cette episode a une Saison parent manquante, incorrecte ou invalide!');

    require_once DOSSIER_MODELS . '/Scene.php';
    $scenes = scenes_enfants_de_episode_triees_numero($episode_trouve->id);

    $fratrie_episodes = episodes_enfants_du_chapitre_triees_numero($chapitre_parent->id);

    foreach($fratrie_episodes as $un_episode) {
        if($un_episode->numero == $episode_trouve->numero-1 && $episode_trouve->numero-1 >= 1)
            $episode_precedent = $un_episode;
        elseif($un_episode->numero == $episode_trouve->numero+1)
            $episode_suivant = $un_episode;
    }

    // Récupération des participations pour l'épisode
    require_once DOSSIER_MODELS . '/Participation.php';
    $participations_episodes = recuperer_participations_via_episodes($episode_trouve->id);

    // AFFICHAGE
    
    require_once DOSSIER_MODELS . '/Personnage.php';
    $html_title = 'Episode n°' . $episode_trouve->numero . ' : ' . $episode_trouve->titre
              . ' | Chapitre ' . $chapitre_parent->numero
              . ' | Saison ' . $saison_parent->numero;
    include_once DOSSIER_VIEWS . '/aventure/episode.html.php';
}
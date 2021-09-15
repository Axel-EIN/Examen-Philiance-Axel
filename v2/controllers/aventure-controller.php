<?php
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

/**
 *  AVENTURE HOME
 */

function afficher_aventure() {
    // Ce contrôlleur construit toute la page Aventure

    // Récupération des données
    $saisons = Saison::all();
    $numero_saison_courante = 1;

    if (!empty($_GET['saison']) && is_numeric($_GET['saison']) && $_GET['saison'] > 0)
        $numero_saison_courante = $_GET['saison'];

    $saison_trouve = Saison::retrieveByField('numero', $numero_saison_courante, SimpleOrm::FETCH_ONE);
    if ($saison_trouve == null) redirection('404', 'Désolé! Cette Saison n\'existe pas!');

    // AFFICHAGE
    $html_title = $saison_trouve->titre . ' | ' . 'Saison ' . $saison_trouve->numero . ' d\'une ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/aventure/aventure.html.php';
}

function afficher_saison_header(object $saison_trouve, array $saisons) {
    // Ce contrôlleur affiche la partie header d'une saison

    // On trouve la position de la Saison dans le tableau des Saisons
    $position_cle_saison = array_search($saison_trouve, $saisons);

    $saison_precedente = '';
    $saison_suivante = '';

    if (!empty($saisons[$position_cle_saison-1]))
        $saison_precedente = $saisons[$position_cle_saison-1];
    
    if (!empty($saisons[$position_cle_saison+1]))
        $saison_suivante = $saisons[$position_cle_saison+1];

    // AFFICHAGE
    include_once DOSSIER_VIEWS . '/aventure/saison-header.html.php'; 
}

function afficher_liste_chapitres(int $saison_id) {
    // Ce contrôlleur affiche tout les chapitres d'une saison

    $chapitres = Chapitre::retrieveByField('id_saison', $saison_id, SimpleOrm::FETCH_MANY);

    if ($chapitres == null)
        $chapitres_dispo = false;
    else
        include_once DOSSIER_VIEWS . '/aventure/afficher-liste-chapitres.html.php'; // AFFICHAGE
}

function afficher_un_chapitre(object $chapitre) {
    // Ce controlleur afficher la partie HTML d'une section CHAPITRE

    $episodes = Episode::retrieveByField('id_chapitre', $chapitre->id, SimpleOrm::FETCH_MANY, SimpleOrm::options('numero'));
    if ($episodes == null) $episodes_dispo = false;

    $r = 0; $g = 0; $b = 0;
    couleur_hexa_plus_sombre_rgb($chapitre->couleur, $r, $g, $b, 30);

    // AFFICHAGE
    include DOSSIER_VIEWS . '/aventure/afficher-un-chapitre.html.php'; 
}

/**
 *  LIRE UN EPISODE
 */

function afficher_episode() {

    // Vérification des paramètres d'URL
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('404','Informations pour trouver l\'episode invalides ou manquantes');

    // Récupération des données
    $episode_trouve = Episode::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($episode_trouve === null) redirection ('404','Désolé! Cette espisode n\existe pas!');

    $chapitre_parent = Chapitre::retrieveByField('id', $episode_trouve->id_chapitre, SimpleOrm::FETCH_ONE);
    if ($chapitre_parent === null)
        redirection('404', 'Cette episode a un Chapitre parent manquant, incorrect ou invalide!');

    $saison_parent = Saison::retrieveByField('id', $episode_trouve->id_saison, SimpleOrm::FETCH_ONE);
    if ($saison_parent === null)
        redirection('404', 'Cette episode a une Saison parent manquante, incorrecte ou invalide!');

    $scenes = scenes_enfants_de_episode_triees_numero($episode_trouve->id);

    $fratrie_episodes = episodes_enfants_du_chapitre_triees_numero($chapitre_parent->id);

    foreach($fratrie_episodes as $un_episode) {
        if($un_episode->numero == $episode_trouve->numero-1 && $episode_trouve->numero-1 >= 1)
            $episode_precedent = $un_episode;
        elseif($un_episode->numero == $episode_trouve->numero+1)
            $episode_suivant = $un_episode;
    }

    // AFFICHAGE
    $html_title = 'Episode n°' . $episode_trouve->numero . ' : ' . $episode_trouve->titre
              . ' | Chapitre ' . $chapitre_parent->numero
              . ' | Saison ' . $saison_parent->numero;
    include_once DOSSIER_VIEWS . '/aventure/episode.html.php';
}
<?php
require_once DOSSIER_MODELS . '/Saison.php'; // IMPORT => Modèle Saison

function afficher_aventure() { // Ce contrôlleur construit toute la page Aventure
    $saisons = Saison::all();
    $numero_saison_courante = 1;

    if (!empty($_GET['saison']) && is_numeric($_GET['saison']) && $_GET['saison'] > 0)
        $numero_saison_courante = $_GET['saison'];

    $saison_trouve = Saison::retrieveByField('numero', $numero_saison_courante, SimpleOrm::FETCH_ONE);
    if ($saison_trouve == null) redirection('404');

    $html_title = $saison_trouve->titre . ' | ' . 'Saison ' . $saison_trouve->numero . ' d\'une ' . NOM_DU_SITE;

    include_once DOSSIER_VIEWS . '/aventure.html.php'; // CONSTRUCTION DE L'AFFICHAGE
}

function afficher_saison_header(object $saison_trouve, array $saisons) { // Ce contrôlleur affiche la partie header d'une saison
    $position_cle_saison = array_search($saison_trouve, $saisons); // On trouve la position de la Saison dans le tableau des Saisons

    $saison_precedente = '';
    $saison_suivante = '';

    if (!empty($saisons[$position_cle_saison-1])) // Si saison précédente dans le tableau existe
        $saison_precedente = $saisons[$position_cle_saison-1];
    
    if (!empty($saisons[$position_cle_saison+1]))  // Si saison suivante dans le tableau existe
        $saison_suivante = $saisons[$position_cle_saison+1];

    include_once DOSSIER_VIEWS . '/parts/saison-header.html.php'; // AFFICHAGE
}

function afficher_liste_chapitres(int $saison_id) { // Ce contrôlleur affiche tout les chapitres d'une saison
    require_once DOSSIER_MODELS . '/Chapitre.php';
    
    $chapitres = Chapitre::retrieveByField('id_saison', $saison_id, SimpleOrm::FETCH_MANY);

    if ($chapitres == null)
        $chapitres_dispo = false;
    else
        include_once DOSSIER_VIEWS . '/parts/afficher-liste-chapitres.html.php'; // AFFICHAGE
}

function afficher_un_chapitre(object $chapitre) {
    require_once DOSSIER_MODELS . '/Episode.php'; // Import modèle

    $episodes = Episode::retrieveByField('id_chapitre', $chapitre->id, SimpleOrm::FETCH_MANY);
    if ($episodes == null) $episodes_dispo = false;

    $r = 0;
    $g = 0;
    $b = 0;
    couleur_hexa_plus_sombre_rgb($chapitre->couleur, $r, $g, $b, 30);

    include DOSSIER_VIEWS . '/parts/afficher-un-chapitre.html.php'; // AFFICHAGE
}
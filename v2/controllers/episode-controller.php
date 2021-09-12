<?php
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_episode() {

    // Vérification des paramètres d'URL obligatoire MODE ID
    if (!empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

        $episode_trouve = Episode::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
        if ($episode_trouve === null)
            redirection('404', 'Cette episode n\'existe pas!');

        $saison_parent = Saison::retrieveByField('id', $episode_trouve->id_saison, SimpleOrm::FETCH_ONE);
        if ($saison_parent === null)
            redirection('404', 'Cette episode n\'a pas encore de Saison parent!');

        $episode_numero = $episode_trouve->numero;
        $saison_numero = $saison_parent->numero;

    // Vérification des paramètres d'URL obligatoire MODE NUMERO + SAISON
    } elseif (  !empty($_GET['episode']) && is_numeric($_GET['episode']) && $_GET['episode'] > 0
                && !empty($_GET['saison']) && is_numeric($_GET['saison']) && $_GET['saison'] > 0) {

        $episode_numero = $_GET['episode'];
        $saison_numero = $_GET['saison'];
        
        $saison_parent = Saison::retrieveByField('numero', $saison_numero, SimpleOrm::FETCH_ONE);
        if ($saison_parent === NULL)
            redirection('404','Cette Saison n\'existe pas!');
        
        $episodes_de_la_saison = Episode::retrieveByField('id_saison', $saison_parent->id, SimpleOrm::FETCH_MANY);
        if ($episodes_de_la_saison === null)
            redirection('404','Il n\'y a pas encore d\'episodes pour cette Saison!');
        
        $episode_trouve = '';

        foreach ($episodes_de_la_saison as $un_episode_de_la_saison)
            if ($un_episode_de_la_saison->numero == $_GET['episode'])
                $episode_trouve = $un_episode_de_la_saison;

        if ($episode_trouve == '')
            redirection('404','L\'Episode n\'a pas pu être trouvé');
           
        } else
            redirection('404','Les informations pour retrouver l\'épisode sont invalides ou manquantes');
        
    $chapitre_parent = Chapitre::retrieveByField('id', $episode_trouve->id_chapitre, SimpleOrm::FETCH_ONE);
    if ($chapitre_parent === null)
      redirection('404', 'Cette episode n\'a pas encore de Chapitre parent!');

    $scenes = scenes_enfants_de_episode_triees_numero($episode_trouve->id);

    $episode_precedent = Episode::retrieveByField('numero', $episode_trouve->numero-1, SimpleOrm::FETCH_ONE);
    $episode_suivant = Episode::retrieveByField('numero', $episode_trouve->numero+1, SimpleOrm::FETCH_ONE);

    // TRAITEMENT POUR L'AFFICHAGE
    $chapitre_parent_html_title = ' | Chapitre ' . $chapitre_parent->numero;
    $saison_parent_html_title = ' | Saison ' . $saison_parent->numero;

    $html_title = 'Episode n°' . $episode_trouve->numero . ' : ' . $episode_trouve->titre . $chapitre_parent_html_title . $saison_parent_html_title;

    include_once DOSSIER_VIEWS . '/episode.html.php';
}
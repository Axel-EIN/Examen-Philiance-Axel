<?php
require_once DOSSIER_MODELS . '/Personnage.php';
require_once DOSSIER_MODELS . '/Clan.php';

function afficher_personnages() {
    // Affiche l'index avec tout les personnages

    // VERIFICATION des paramètres d'URL pour spécifier la saison
    if (!empty($_GET['saison']) && is_numeric($_GET['saison']) && $_GET['saison'] > 0)
        $numero_saison_courante = $_GET['saison'];
    else
        $numero_saison_courante = 1;

    // RECUPERATION des saisons
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

    // RECUPERATION des personnages
    $personnages = Personnage::all();
    $pjs = tout_les_personnages_joueurs();
    $pnjs = tout_les_personnages_non_joueurs();

    // AFFICHAGE
    $html_title = 'Les personnages | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/personnages/accueil-personnages.php';
}

function afficher_profil_personnage() {
    // Affiche l'index avec tout les personnages

    // VERIFICATION des paramètres d'URL pour spécifier le personnage
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('500', 'Désolé ! Les paramètres pour trouver un personnage sont invalides ou manquants !');

    // RECUPERATION des données du personnage
    $personnage_trouve = Personnage::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($personnage_trouve == null) redirection('404', 'Désolé ! Ce personnage n\'existe pas !');

    $personnage_clan = Clan::retrieveByField('id', $personnage_trouve->clan_id, SimpleOrm::FETCH_ONE);

    require_once DOSSIER_MODELS . '/Classe.php';
    $personnage_classe = Classe::retrieveByField('id', $personnage_trouve->classe_id, SimpleOrm::FETCH_ONE);

    require_once DOSSIER_MODELS . '/Ecole.php';
    $personnage_ecole = Ecole::retrieveByField('id', $personnage_trouve->ecole_id, SimpleOrm::FETCH_ONE);

    require_once DOSSIER_MODELS . '/Utilisateur.php';
    $personnage_utilisateur = Utilisateur::retrieveByField('id', $personnage_trouve->utilisateur_id, SimpleOrm::FETCH_ONE);

    // AFFICHAGE
    $html_title = 'Profil de ' . $personnage_trouve->nom . ' ' . $personnage_trouve->prenom . ' | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/personnages/profil-personnage.php';
}
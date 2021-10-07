<?php
require_once DOSSIER_MODELS . '/Personnage.php';
require_once DOSSIER_MODELS . '/Clan.php';
require_once DOSSIER_MODELS . '/Utilisateur.php';

function afficher_personnages() {
    // Affiche la LISTE de tout les personnages

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
    $pjs = recuperer_pjs();
    $pnjs = recuperer_pnjs();

    // AFFICHAGE
    $html_title = 'Les personnages | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/personnages/accueil-personnages.html.php';
}

function afficher_profil_personnage() {
    // Affiche PROFIL PUBLIC d'un personnage

    // VERIFICATION des paramètres d'URL pour spécifier le personnage
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('500', 'Désolé ! Les paramètres pour trouver un personnage sont invalides ou manquants !');

    // RECUPERATION des données du personnage
    $personnage_trouve = recuperer_un_personnage($_GET['id']);
    if ($personnage_trouve == null) redirection('404', 'Désolé ! Ce personnage n\'existe pas !');

    $personnage_clan = recuperer_un_clan($personnage_trouve->clan_id);

    require_once DOSSIER_MODELS . '/Classe.php';
    $personnage_classe = recuperer_une_classe($personnage_trouve->classe_id);

    require_once DOSSIER_MODELS . '/Ecole.php';
    $personnage_ecole = recuperer_une_ecole($personnage_trouve->ecole_id);

    $personnage_utilisateur = recuperer_un_utilisateur($personnage_trouve->utilisateur_id);

    require_once DOSSIER_MODELS . '/Participation.php';
    $participations_du_personnage = recuperer_toutes_les_participations_personnage($personnage_trouve->id);
    $total_xp = 40 + somme_xp_participations_personnage($personnage_trouve->id);
    $rang = calcul_rang($total_xp);
    require_once DOSSIER_MODELS . '/Scene.php';
    require_once DOSSIER_MODELS . '/Episode.php';

    // AFFICHAGE
    $html_title = 'Profil de ' . $personnage_trouve->nom . ' ' . $personnage_trouve->prenom . ' | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/personnages/profil-personnage.html.php';
}

function afficher_fiche_personnage() {
    // VERIF
    if(!utilisateur_connecte()) redirection('403', 'Désolé ! Veuillez-vous connecter !');

    if(empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1 ) redirection('500', 'Erreur Interne au serveur !');

    // DONNEES
    $personnage_trouve = recuperer_un_personnage($_GET['id']);

    if($personnage_trouve->utilisateur_id != $_SESSION['id'])
        redirection('403', 'Désolé, vous ne pouvez pas accéder aux fiches personnages des autres joueurs !');

    $personnage_clan = recuperer_un_clan($personnage_trouve->clan_id);
    require_once DOSSIER_MODELS . '/Ecole.php';
    $personnage_ecole = recuperer_une_ecole($personnage_trouve->ecole_id);
    require_once DOSSIER_MODELS . '/Classe.php';
    $personnage_classe = recuperer_une_classe($personnage_trouve->classe_id);
    $personnage_utilisateur = recuperer_un_utilisateur($personnage_trouve->utilisateur_id);

    require_once DOSSIER_MODELS . '/Fiche.php';
    $fiche_personnage = recuperer_fiche_personnage($personnage_trouve->id);

    // AFFICHAGE
    $html_title = 'Fiche de ' . $personnage_trouve->nom . ' ' . $personnage_trouve->prenom . ' | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/personnages/fiche-personnage.html.php';
}
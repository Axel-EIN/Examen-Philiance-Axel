<?php

// IMPORTATION des modèles des données
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration_saisons() {
    // Affiche Panneau Admin des Saisons

    // VERIF Admin Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée !'); 

    // RECUPERATION données
    $saisons= Saison::all();

    // AFFICHAGE
    $html_title = 'Administration des Saisons' .  ' | ' . NOM_DU_SITE;
    $h1 = 'Administration des Saisons';
    include_once DOSSIER_VIEWS . '/admin/saisons/admin-saisons.html.php';
}

function admin_creer_saison() {
    // Affiche Formulaire Creer Saison

    // VERIFICATION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée !');

    // RECUPERATION des données
    $toutes_les_saisons = Saison::all(SimpleOrm::options('numero', SimpleOrm::ORDER_ASC));
    
     // AFFICHAGE
    $html_title = 'Créer une Saison | Administration de ' . NOM_DU_SITE;
    $h1 = 'Créer une Saison';
    include_once DOSSIER_VIEWS . '/admin/saisons/creer-saison.html.php';
}

function admin_creer_saison_handler() {
    // Gère les données postées du forumlaire pour creer une saison

     // VERIF Admin Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // VERIFICATION des données postées
    if ( empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['couleur'])
        ) redirection('admin-creer-saison', 'Informations postées manquantes ou invalides !', 'warning');
    
    // GESTION de l'image (qui est facultative)
    if (verif_image() === false)
        redirection('admin-creer-saison', 'Image invalide, veuillez réessayer avec un format ou une taille appropriée !', 'warning');
    elseif (verif_image() === null)
        $image_nouvel_url = URL_IMAGE_DEFAUT_1080;
    else
        $image_nouvel_url = uploader_image($_POST['numero'], 0, 0, 0);

    // GESTION de la position / numero
    reordonner_fratrie(-1, $_POST['numero'], [], toutes_les_saisons());
    
    // CREATION et SAUVEGARDE des données
    $nouvelle_saison = new Saison;
    $nouvelle_saison->numero = $_POST['numero'];
    $nouvelle_saison->titre = htmlspecialchars($_POST['titre']);
    $nouvelle_saison->image = $image_nouvel_url;
    $nouvelle_saison->couleur = htmlspecialchars($_POST['couleur']);

    $nouvelle_saison->save();

    // AFFICHAGE
    redirection('aventure&saison=' . $nouvelle_saison->numero, 'La saison a bien été créée !', 'success');
}

function admin_modifier_saison() {
    // Affiche le formulaire pour modifier une saison

    // VERIF Admin Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !'); 

    // VERIF : paramètres d'URL
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('404', 'Paramètres manquants ou invalides pour retrouver la saison !');

    // RECUPERATION des données
    $saison_trouve = Saison::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($saison_trouve === null)
        redirection('404', 'Cette saison n\'existe pas !');

    $toutes_les_saisons = Saison::all();
    
    // AFFICHAGE
    $html_title = 'Modifier une saison' .  ' | Administration de ' . NOM_DU_SITE;
    $h1 = 'Modifier une saison';
    include_once DOSSIER_VIEWS . '/admin/saisons/modifier-saison.html.php'; 
}

function admin_modifier_saison_handler() {
    // Gère les données postées du forumlaire pour modifier une saison

    // VERIF admin connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');
    
     // VERIFICATION des données postées
    if (
        empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1
        || empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['couleur'])
        ) redirection('admin-modifier-episode' . '&id=' . $_GET['id'], 'Informations postées manquantes ou invalides !', 'warning');
  
    // RECUPERATION des données
    $saison_trouve = saison_trouve_par_id($_GET['id']);
        
    // GESTION de l'image (qui est facultative)
    if (verif_image() === false)
        redirection('admin-modifier-saison' . '&id=' . $_GET['id'], 'Image Invalide, veuillez réessayer avec un format ou une taille appropriée !', 'warning');
    elseif (verif_image() === null)
        $image_nouvel_url = $saison_trouve->image;
    else
        $image_nouvel_url = uploader_image($_POST['numero'], 0, 0, 0, $saison_trouve->image);
     
    // GESTION de la position / numero
    if ($saison_trouve->numero != $_POST['numero'])
        reordonner_fratrie($saison_trouve->numero, $_POST['numero'], toutes_les_saisons(), toutes_les_saisons());
    
    // SAUVEGARDE des données de la Saison
    $saison_trouve->numero = $_POST['numero'];
    $saison_trouve->titre = htmlspecialchars($_POST['titre']);
    $saison_trouve->couleur = htmlspecialchars($_POST['couleur']);
    $saison_trouve->image = $image_nouvel_url;

    $saison_trouve->save();

    // Affichage de la VUE
    redirection('aventure&saison=' . $saison_trouve->numero, 'La saison a bien été modifiée !', 'success', '#tete-lecture');
}

function admin_supprimer_saison_handler() {
    // Gère la suppression de la saison demandée

    // VERIF Admin
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');
    
     // VERIFICATION du paramètre URL GET
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('500', 'Informations manquantes ou invalides pour retrouver la saison !');

    $saison_trouve = saison_trouve_par_id($_GET['id']);

    if (chapitres_enfants_de_saison($_GET['id']))
        redirection('aventure&saison=' . $saison_trouve->numero,
                    'Cette saison a des chapitres enfants, veuillez les supprimer au préalable', 'danger', '#tete-lecture');

    supprimer_image($saison_trouve->image, 'saisons/');

    // GESTION de la position / numero
    reordonner_fratrie($saison_trouve->numero, -1, toutes_les_saisons(), []);

    $saison_trouve->delete();

    // AFFICHAGE
    if (!empty($_GET['depuis'])) redirection($_GET['depuis'], 'La saison a bien été supprimée !');
    else redirection('aventure', 'La saison a bien été supprimée !', 'success');
}

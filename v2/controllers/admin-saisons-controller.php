<?php

// IMPORTATION des modèles des données
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration_saisons() {
    // Affiche la page du panneau d'administration qui liste des saisons

    // // VERIF Admin Connecté
    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); 

    // // RECUPERATION données
    // $episodes= Episode::all();

    // // AFFICHAGE
    // $html_title = 'Administration des Episodes' .  ' | ' . NOM_DU_SITE;
    // $h1 = 'Administration des Episodes';
    // include_once DOSSIER_VIEWS . '/admin/panneau-admin-episodes.html.php';
}

function admin_creer_saison() {
    // Affiche le formulaire pour creer une saison
    
    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin

    // if (!empty($_GET['id_chapitre']) && is_numeric($_GET['id_chapitre']) && $_GET['id_chapitre'] > 0) {
    //     $chapitre_parent = chapitre_trouve_par_id($_GET['id_chapitre']);
    //     $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);
    //     $episodes_enfants = episodes_enfants_du_chapitre_triees_numero($chapitre_parent->id);
    //     $get_chapitre = '&id_chapitre=' . $_GET['id_chapitre'];
    // } else $get_chapitre = '';

    // $tous_les_episodes = Episode::all();
    // $tous_les_chapitres = Chapitre::all();
    // $toutes_les_saisons = Saison::all();
    // $toutes_les_scenes = Scene::all();
    
    // $html_title = 'Créer un Episode | Administration de ' . NOM_DU_SITE;
    // $h1 = 'Créer un Episode';

    // include_once DOSSIER_VIEWS . '/admin/creer-episode.html.php'; // AFFICHAGE

}

function admin_creer_saison_handler() {
    // Gère les données postées du forumlaire pour creer une saison

    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin Connecté

    // if (!empty($_POST['id_chapitre'])) $id_chapitre = $_POST['id_chapitre'];
    // elseif (!empty($_GET['id_chapitre'])) $id_chapitre = $_GET['id_chapitre'];
    
    // if ( // VERIFICATION des données postées
    //     empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
    //     || empty($id_chapitre) || !is_numeric($id_chapitre) || $id_chapitre < 1
    //     || empty($_POST['titre']) || is_numeric($_POST['titre'])
    //     || empty($_POST['resume']) || is_numeric($_POST['resume'])
    //     ) redirection('admin-creer-episode', 'Informations postées manquantes ou invalides', 'warning');
    
    // $chapitre_parent = chapitre_trouve_par_id($id_chapitre);
    // $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);

    // // GESTION de l'image (qui est facultative donc la valeur null est autorisée)
    // if (verif_image() === false)
    //     redirection('admin-creer-episode', 'Image Invalide, veuillez réessayer avec un format ou taille appropriées', 'warning');
    // elseif (verif_image() === null)
    //     $image_nouvel_url = URL_IMAGE_DEFAUT_540;
    // else
    //     $image_nouvel_url = uploader_image($saison_parent->numero, $chapitre_parent->numero, $_POST['numero'], 0);

    // // GESTION de la position / numero
    // reordonner_fratrie(-1, $_POST['numero'], [], episodes_enfants_du_chapitre($id_chapitre));
    
    // // CREATION et SAUVEGARDE des données
    // $nouvel_episode = new Episode;
    // $nouvel_episode->numero = $_POST['numero'];
    // $nouvel_episode->titre = htmlspecialchars($_POST['titre']);
    // $nouvel_episode->resume = htmlspecialchars($_POST['resume']);
    // $nouvel_episode->id_saison = $saison_parent->id;
    // $nouvel_episode->image = $image_nouvel_url;
    // $nouvel_episode->id_chapitre = $id_chapitre;;

    // $nouvel_episode->save();

    // // AFFICHAGE de la VUE
    // redirection('episode&id=' . $nouvel_episode->id, 'L\'Episode a bien été crée!', 'success');

}

function admin_modifier_saison() {
    // Affiche le formulaire pour modifier une saison

    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin Connecté

    // // VERIF : paramètres d'URL
    // if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
    //     redirection('404', 'Paramètres manquants ou invalide pour retrouver l\'episode');

    // $episode_trouve = Episode::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    // if ($episode_trouve === null)
    //     redirection('404', 'Cette episode n\'existe pas.');

    // $chapitre_parent = chapitre_trouve_par_id($episode_trouve->id_chapitre);
    // $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);

    // $episodes_enfants = episodes_enfants_du_chapitre_triees_numero($chapitre_parent->id);
    // $tous_les_episodes = Episode::all();
    // $tous_les_chapitres = Chapitre::all();
    // $toutes_les_saisons = Saison::all();
    
    // $html_title = 'Modifier un episode' .  ' | Administration de ' . NOM_DU_SITE;
    // $h1 = 'Modifier un episode';

    // include_once DOSSIER_VIEWS . '/admin/modifier-episode.html.php'; // AFFICHAGE
}

function admin_modifier_saison_handler() {
    // Gère les données postées du forumlaire pour modifier une saison

    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin Connecté
    
    // if ( // VERIFICATION des données postées
    //     empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1
    //     || empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
    //     || empty($_POST['id_chapitre']) || !is_numeric($_POST['id_chapitre']) || $_POST['id_chapitre'] < 1
    //     || empty($_POST['titre']) || is_numeric($_POST['titre'])
    //     || empty($_POST['resume']) || is_numeric($_POST['resume'])
    //     ) redirection('admin-modifier-episode' . '&id=' . $_GET['id'], 'Informations postées manquantes ou invalides', 'warning');
  
    //     $episode_trouve = episode_trouve_par_id($_GET['id']);
    //     $chapitre_parent = chapitre_trouve_par_id($episode_trouve->id_chapitre);
    //     $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);
        
    // // GESTION de l'image (qui est facultative donc la valeur null est autorisée)
    // if (verif_image() === false)
    //     redirection('admin-modifier-episode' . '&id=' . $_GET['id'], 'Image Invalide, veuillez réessayer avec un format ou taille appropriées', 'warning');
    // elseif (verif_image() === null)
    //     $image_nouvel_url = $episode_trouve->image;
    // else
    //     $image_nouvel_url = uploader_image($saison_parent->numero, $chapitre_parent->numero, $episode_trouve->numero, 0, $episode_trouve->image);
     
    // // GESTION de la position / numero
    // if ($episode_trouve->numero != $_POST['numero'] || $episode_trouve->id_chapitre != $_POST['id_chapitre'])
    //     reordonner_fratrie($episode_trouve->numero, $_POST['numero'], episodes_enfants_du_chapitre($chapitre_parent->id), episodes_enfants_du_chapitre($_POST['id_chapitre']));
    
    // // SAUVEGARDE des données de la scène initiale
    // $episode_trouve->numero = $_POST['numero'];
    // $episode_trouve->titre = htmlspecialchars($_POST['titre']);
    // $episode_trouve->resume = htmlspecialchars($_POST['resume']);
    // $episode_trouve->image = $image_nouvel_url;
    // $episode_trouve->id_chapitre = $_POST['id_chapitre'];;

    // $episode_trouve->save();

    // // Affichage de la VUE
    // redirection('episode&id=' . $episode_trouve->id, 'L\'episode a bien été modifiée!', 'success', '#tete-lecture');
}

function admin_supprimer_saison_handler() {
    // Gère la suppression de la saison demandée

    // if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin
    
    //  // VERIFICATION du paramètre URL GET
    // if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
    //     redirection('500', 'Informations manquantes ou invalides pour le traitement interne dans le serveur');

    // $episode_trouve = episode_trouve_par_id($_GET['id']);
    // $chapitre_parent = chapitre_trouve_par_id($episode_trouve->id_chapitre);
    // $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);

    // if (scenes_enfants_de_episode($_GET['id']))
    //     redirection('episode&id=' . $episode_trouve->id,
    //                 'Cette episode a des scènes enfants, veuillez les supprimer au préalable', 'danger', '#tete-lecture');

    // supprimer_image($episode_trouve->image, 'episodes/');

    // // GESTION de la position / numero
    // reordonner_fratrie($episode_trouve->numero, -1, episodes_enfants_du_chapitre($episode_trouve->id_chapitre), []);

    // $episode_trouve->delete();

    // // AFFICHAGE de la VUE
    // if (!empty($_GET['depuis'])) redirection($_GET['depuis'], 'L\'episode a bien été supprimée!');
    // else redirection('aventure' . '&saison=' . $saison_parent->numero , 'L\'episode a bien été supprimée!', 'success', '#tete-lecture-ch' . $chapitre_parent->numero , $chapitre_parent->numero);
}

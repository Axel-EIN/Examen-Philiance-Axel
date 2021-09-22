<?php

// IMPORTATION des modèles des données
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration_chapitres() {
    // Affiche la page du panneau d'administration qui liste des chapitres

    // VERIF Admin Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); 

    // RECUPERATION données
    $chapitres= Chapitre::all();

    // AFFICHAGE
    $html_title = 'Administration des chapitres' .  ' | ' . NOM_DU_SITE;
    $h1 = 'Administration des chapitres';
    include_once DOSSIER_VIEWS . '/admin/panneau-admin-chapitres.html.php';
}

function admin_creer_chapitre() {
    // Affiche le formulaire pour creer un chapitre
    
    // VERIFICATION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!');

    // VERIFICATION si on a un get id_chapitre donc si on doit afficher un formulaire pré-rempli
    if (!empty($_GET['id_saison']) && is_numeric($_GET['id_saison']) && $_GET['id_saison'] > 0) {

        // RECUPERATION DES DONNEES pour pré-remplir le formulaire
        $saison_parent = saison_trouve_par_id($_GET['id_saison']);
        $chapitres_enfants = chapitres_enfants_de_saison_tries_numero($saison_parent->id);
        $get_saison = '&id_saison=' . $_GET['id_saison'];

    } else $get_saison = '';

    // RECUPERATION DES DONNEES pour les tableaux de liste dérouante en JavaScript
    $tous_les_episodes = Episode::all();
    $tous_les_chapitres = Chapitre::all();
    $toutes_les_saisons = Saison::all();
    $toutes_les_scenes = Scene::all();
    
     // AFFICHAGE
    $html_title = 'Créer un Episode | Administration de ' . NOM_DU_SITE;
    $h1 = 'Créer un Episode';
    include_once DOSSIER_VIEWS . '/admin/creer-episode.html.php';
}

function admin_creer_chapitre_handler() {
    // Gère les données postées du forumlaire pour creer un chapitre

    // VERIRIFACTION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!');

    // VERIFICATION si le paramètre id_saison vient d'un formulaire pré-rempli (POST) ou non (GET)
    if (!empty($_POST['id_saison'])) $id_saison = $_POST['id_saison'];
    elseif (!empty($_GET['id_saison'])) $id_saison = $_GET['id_saison'];
    
     // VERIFICATION de l'intégrité des données postées
    if (
        empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($id_saison) || !is_numeric($id_saison) || $id_saison < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['citation']) || is_numeric($_POST['citation'])
        || empty($_POST['id_mj']) || !is_numeric($_POST['id_mj']) || $_POST['id_mj'] < 1
        )
        redirection('admin-creer-episode', 'Informations postées manquantes ou invalides', 'warning');
    
    $saison_parent = saison_trouve_par_id($id_saison);

    // GESTION de l'image (qui est facultative donc la valeur null est autorisée)
    if (verif_image() === false)
        redirection('admin-creer-episode', 'Image Invalide, veuillez réessayer avec un format ou taille appropriées', 'warning');
    elseif (verif_image() === null)
        $image_nouvel_url = URL_IMAGE_DEFAUT_1080;
    else
        $image_nouvel_url = uploader_image($saison_parent->numero, $_POST['numero'], 0, 0);

    // GESTION de la position / numero
    reordonner_fratrie(-1, $_POST['numero'], [], chapitres_enfants_de_saison($id_saison));
    
    // CREATION et SAUVEGARDE des données
    $nouveau_chapitre = new Chapitre;
    $nouveau_chapitre->numero = $_POST['numero'];
    $nouveau_chapitre->titre = htmlspecialchars($_POST['titre']);
    $nouveau_chapitre->citation = htmlspecialchars($_POST['citation']);
    $nouveau_chapitre->id_saison = $saison_parent->id;
    $nouveau_chapitre->image = $image_nouvel_url;
    $nouveau_chapitre->mj = $_POST['mj'];

    $nouveau_chapitre->save();

    // AFFICHAGE de la VUE
    redirection('aventure&saison=' . $saison_parent->numero . '#tete-lecture-ch' . $nouveau_chapitre->numero, 'L\'Episode a bien été crée!', 'success');

}

function admin_modifier_chapitre() {
    // Affiche le formulaire pour modifier un chapitre

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

function admin_modifier_chapitre_handler() {
    // Gère les données postées du forumlaire pour modifier un chapitre

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

function admin_supprimer_chapitre_handler() {
    // Gère la suppression du chapitre demandé

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

<?php

// IMPORTATION des modèles des données
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration_scenes() {
    // Affiche la page du panneau d'administration qui liste les scènes

    // VERIFICATION si Administrateur est Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // RECUPERATION des données des scènes
    $scenes = Scene::all();
    $episode_parent = 

    // AFFICHAGE
    $html_title = 'Administration des Scènes' .  ' | ' . NOM_DU_SITE;
    $h1 = 'Administration des Scènes';
    include_once DOSSIER_VIEWS . '/admin/scenes/admin-scenes.html.php';
}

function admin_creer_scene() {
    // Affiche le formulaire pour creer une scene
    
    // VERIFICATION si Administrateur est connecte
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // PARAMETRAGE du formulaire pré-rempli si on arrive depuis un bouton
    if (
        !empty($_GET['id_episode']) && is_numeric($_GET['id_episode']) && $_GET['id_episode'] > 0
        && !empty($_GET['numero']) && is_numeric($_GET['numero']) && $_GET['numero'] > 0
        )
    {
        // RECUPERATION des données pour le formulaire pré-rempli si on vient depuis un bouton Insérer 
        $episode_parent = episode_trouve_par_id($_GET['id_episode']);
        $chapitre_parent = chapitre_trouve_par_id($episode_parent->id_chapitre);
        $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);
        $scenes_enfants = scenes_enfants_de_episode_triees_numero($episode_parent->id);
        $get_episode = '&id_episode=' . $_GET['id_episode'];
        
    } else $get_episode = '';
    
    // RECUPERATION des données pour les listes déroulantes en JavaScript
    $tous_les_episodes = Episode::all();
    $tous_les_chapitres = Chapitre::all();
    $toutes_les_saisons = Saison::all();

    // AFFICHAGE
    $html_title = 'Créer une scène | Administration de ' . NOM_DU_SITE;
    $h1 = 'Créer une scène';
    include_once DOSSIER_VIEWS . '/admin/scenes/creer-scene.html.php'; 

}

function admin_creer_scene_handler() {
    // Gère les données postées du forumlaire pour creer scene

    // VERIF Admin connecte
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // RECUPERATION des variable id_episode et numero selon si on arrive depuis un bouton (GET) ou pas (POST)
    if (!empty($_POST['id_episode']) && is_numeric($_POST['id_episode']) && $_POST['id_episode'] > 0) {
            $id_episode = $_POST['id_episode'];
        }
    elseif (
        !empty($_GET['id_episode']) && is_numeric($_GET['id_episode']) && $_GET['id_episode'] > 0) {
            $id_episode = $_GET['id_episode'];
        }
    else redirection('admin-creer-scene', 'LOL Informations postées manquantes ou invalides !', 'warning');
    
    // VERIFICATION de l'intégrité des autres données postées
    if (
        empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['temps']) || is_numeric($_POST['temps'])
        || empty($_POST['texte']) || is_numeric($_POST['texte'])
        ) redirection('admin-creer-scene', 'Informations postées manquantes ou invalides !', 'warning');
    
    // RECUPERATION des données
    $episode_parent = episode_trouve_par_id($id_episode);
    $chapitre_parent = chapitre_trouve_par_id($episode_parent->id_chapitre);
    $saison_parent = saison_trouve_par_id($episode_parent->id_saison);

    // GESTION de l'image (l'image est facultative)
    if (verif_image() === false)
        redirection('admin-creer-scene', 'Image invalide ! Veuillez réessayer avec un format ou une taille appropriée !', 'warning');
    elseif (verif_image() === null)
        $image_nouvel_url = URL_IMAGE_DEFAUT_720;
    else
        $image_nouvel_url = uploader_image($saison_parent->numero, $chapitre_parent->numero, $episode_parent->numero, $_POST['numero']);

    // GESTION de la position / numero
    reordonner_fratrie(-1, $_POST['numero'], [], scenes_enfants_de_episode($id_episode));
    
    // CREATION et SAUVEGARDE des données
    $nouvelle_scene = new Scene;
    $nouvelle_scene->numero = $_POST['numero'];
    $nouvelle_scene->titre = htmlspecialchars($_POST['titre']);
    $nouvelle_scene->temps = htmlspecialchars($_POST['temps']);
    $nouvelle_scene->texte = htmlspecialchars($_POST['texte']);
    $nouvelle_scene->image = $image_nouvel_url;
    $nouvelle_scene->id_episode = $id_episode;;

    $nouvelle_scene->save();

    // AFFICHAGE de la VUE
    redirection('episode&id=' . $id_episode . '&scene_id=' . $nouvelle_scene->id,
                'La scène a bien été créée !',
                'success',
                '#scn' . $_POST['numero']);
}

function admin_modifier_scene() {
    // Affiche le formulaire pour modifier scene

    // VERIFICATION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // VERIFICATION de l'intégrité des paramètres d'URL
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('404', 'Paramètres manquants ou invalides pour retrouver la scène');

    // RECUPERATION des données
    $scene_trouve = Scene::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($scene_trouve === null)
        redirection('404', 'Désolé ! Cette scène n\'existe pas.');

    $episode_parent = episode_trouve_par_id($scene_trouve->id_episode);
    $chapitre_parent = chapitre_trouve_par_id($episode_parent->id_chapitre);
    $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);

    $scenes_enfants = scenes_enfants_de_episode_triees_numero($episode_parent->id);

    // RECUPERATION des données pour les listes déroulantes JavaScript
    $tous_les_episodes = Episode::all();
    $tous_les_chapitres = Chapitre::all();
    $toutes_les_saisons = Saison::all();
    
    // AFFICHAGE
    $html_title = 'Modifier une scène' .  ' | Administration de ' . NOM_DU_SITE;
    $h1 = 'Modifier une scène';
    include_once DOSSIER_VIEWS . '/admin/scenes/modifier-scene.html.php';
}

function admin_modifier_scene_handler() {
    // Gère les données postées du forumlaire pour modifier scene

    // VERIF Admin connecte
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');
    
    // VERIFICATION de l'intégrité des données postées
    if ( 
        empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1
        || empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($_POST['id_episode']) || !is_numeric($_POST['id_episode']) || $_POST['id_episode'] < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['temps']) || is_numeric($_POST['temps'])
        || empty($_POST['texte']) || is_numeric($_POST['texte'])
        ) redirection('admin-modifier-scene' . '&id=' . $_GET['id'], 'Informations postées manquantes ou invalides', 'warning');

    // RECUPERATION des DONNEES
    $scene_trouve = scene_trouve_par_id($_GET['id']);
    $episode_parent = episode_trouve_par_id($scene_trouve->id_episode);
    $chapitre_parent = chapitre_trouve_par_id($episode_parent->id_chapitre);
    $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison);
        
    // GESTION de l'image qui est facultative
    if (verif_image() === false)
    {
        redirection('admin-modifier-scene' . '&id=' . $_GET['id'],
                    'Image invalide, veuillez réessayer avec un format ou taille appropriées',
                    'warning');
    }
    elseif (verif_image() === null)
        $image_nouvel_url = $scene_trouve->image;
    else
    {
        $image_nouvel_url = uploader_image( $saison_parent->numero,
                                            $chapitre_parent->numero,
                                            $episode_parent->numero,
                                            $scene_trouve->numero,
                                            $scene_trouve->image);
    }
     
    // GESTION de la position / numero dans le cas où la position change où si on déplace la scène vers un autre épisode
    if ($scene_trouve->numero != $_POST['numero'] || $scene_trouve->id_episode != $_POST['id_episode'])
        reordonner_fratrie( $scene_trouve->numero,
                            $_POST['numero'],
                            scenes_enfants_de_episode($episode_parent->id),
                            scenes_enfants_de_episode($_POST['id_episode']));
    
    // GESTION des liens des personnages dans le text
    $texte_input = htmlspecialchars($_POST['texte']);

    echo '<strong>Affichage du texte après la fonction HTMLSPECIALCHARS</strong> :<br/>';
    echo '<pre>';
    var_dump($texte_input);
    echo '<pre>';

    $tableau = [];
    

    preg_match_all('#\[(.*)\]#Ui', $texte_input, $tableau);

    echo '<strong>Affichage du texte après la fonction PREGMATCH avec le Tableau de prénom</strong> :<br/>';
    echo '<pre>';
    var_dump($tableau);
    echo '<pre>';
    

    require_once DOSSIER_MODELS . '/Personnage.php';
    $tableau_remplacement = [];

    foreach ($tableau[1] as $un_match) {
        echo 'PASSAGE pour ' . $un_match . '<br/>';
        $perso_trouve = personnage_trouve_par_prenom($un_match);
        $tableau_remplacement[] = '<a href="' . route('profil-personnage&id=' . $perso_trouve->id) . '">' . $perso_trouve->prenom . '</a>';
    }

    echo '<strong>Affichage Tableau remplacement</strong> :<br/>';
    echo '<pre>';
    var_dump($tableau_remplacement);
    echo '<pre>';

    $nouveau_texte = preg_replace($tableau[0], $tableau_remplacement, $texte_input);

    echo '<strong>Affichage Texte remplacé</strong> :<br/>';
    echo '<pre>';
    var_dump($nouveau_texte);
    echo '<pre>';

    // SAUVEGARDE des données de la scène
    $scene_trouve->numero = $_POST['numero'];
    $scene_trouve->titre = htmlspecialchars($_POST['titre']);
    $scene_trouve->temps = htmlspecialchars($_POST['temps']);
    $scene_trouve->texte = $nouveau_texte;
    $scene_trouve->image = $image_nouvel_url;
    $scene_trouve->id_episode = $_POST['id_episode'];;

    $scene_trouve->save();

    // AFFICHAGE
    redirection('episode&id=' . $_POST['id_episode'] . '&scene_id=' . $scene_trouve->id,
                'La scène a bien été modifiée !',
                'success',
                '#scn' . $_POST['numero']);
}

function admin_supprimer_scene_handler() {
    // Gère la suppression de la scène demandée

    // VERIFICATION si l'Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisé !');

    // VERIFICATION du paramètre URL GET
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1) 
        redirection('500', 'Informations manquantes ou invalides pour le traitement interne dans le serveur');

    // RECUPERATION de la scène à supprimer
    $scene_trouve = scene_trouve_par_id($_GET['id']);
    
    // SUPPRESION de l'image
    supprimer_image($scene_trouve->image, 'scenes/');

    // GESTION de la position / numero
    reordonner_fratrie($scene_trouve->numero, -1, scenes_enfants_de_episode($scene_trouve->id_episode), []);

    // SUPPRESSION des données
    $scene_trouve->delete();

    // AFFICHAGE
    if (!empty($_GET['depuis'])) redirection($_GET['depuis'], 'La scène a bien été supprimée !');
    else redirection(   'episode&id=' . $scene_trouve->id_episode,
                        'La scène a bien été supprimée !',
                        'success',
                        '#tete-lecture');
}
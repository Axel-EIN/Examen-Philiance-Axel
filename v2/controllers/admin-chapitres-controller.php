<?php

// IMPORTATION des modèles des données
require_once DOSSIER_MODELS . '/Saison.php';
require_once DOSSIER_MODELS . '/Chapitre.php';
require_once DOSSIER_MODELS . '/Episode.php';
require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration_chapitres() {
    // Affiche la page du panneau d'administration qui liste les chapitres

    // VERIF Admin Connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); 

    // RECUPERATION données
    $chapitres = Chapitre::all();

    // RECUPERATION des utilisateurs
    require_once DOSSIER_MODELS . '/Utilisateur.php';
    $utilisateurs = Utilisateur::all();

    // AFFICHAGE
    $html_title = 'Administration des chapitres' .  ' | ' . NOM_DU_SITE;
    $h1 = 'Administration des chapitres';
    include_once DOSSIER_VIEWS . '/admin/admin-chapitres.html.php';
}

function admin_creer_chapitre() {
    // Affiche le formulaire pour creer un chapitre
    
    // VERIFICATION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!');

    // VERIFICATION si on a un get id_saison donc si on doit afficher un formulaire pré-rempli
    if (!empty($_GET['id_saison']) && is_numeric($_GET['id_saison']) && $_GET['id_saison'] > 0) {

        // RECUPERATION DES DONNEES pour pré-remplir le formulaire
        $saison_parent = saison_trouve_par_id($_GET['id_saison']);
        $chapitres_enfants = chapitres_enfants_de_saison_tries_numero($saison_parent->id);
        $get_saison = '&id_saison=' . $_GET['id_saison'];

    } else $get_saison = '';

    // RECUPERATION DES DONNEES pour les tableaux de liste dérouante en JavaScript
    $tous_les_chapitres = Chapitre::all();
    $toutes_les_saisons = Saison::all();

    // RECUPERATION des utilisateurs
    require_once DOSSIER_MODELS . '/Utilisateur.php';
    $utilisateurs = Utilisateur::all();
    
     // AFFICHAGE
    $html_title = 'Créer un Chapitre | Administration de ' . NOM_DU_SITE;
    $h1 = 'Créer un Chapitre';
    include_once DOSSIER_VIEWS . '/admin/creer-chapitre.html.php';
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
        || empty($_POST['couleur'])
        )
        redirection('admin-creer-chapitre', 'Informations postées manquantes ou invalides', 'warning');
    
    $saison_parent = saison_trouve_par_id($id_saison);

    // GESTION de l'image (qui est facultative donc la valeur null est autorisée)
    if (verif_image() === false)
        redirection('admin-creer-chapitre', 'Image invalide, veuillez réessayer avec un format ou taille appropriées', 'warning');
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
    $nouveau_chapitre->couleur = $_POST['couleur'];
    $nouveau_chapitre->image = $image_nouvel_url;
    $nouveau_chapitre->id_mj = $_POST['id_mj'];

    $nouveau_chapitre->save();

    // AFFICHAGE de la VUE
    redirection('aventure&saison=' . $saison_parent->numero,
                 'Le chapitre a bien été crée !', 'success', '', '#tete-lecture-ch' . $nouveau_chapitre->numero);

}

function admin_modifier_chapitre() {
    // Affiche le formulaire pour modifier un chapitre

    // VERIFIFACTION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); 

    // VERIFIFACTION des paramètres d'URL
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('404', 'Paramètres manquants ou invalides pour retrouver l\'épisode');

    // RECUPERATION des données du chapitre à modifier
    $chapitre_trouve = Chapitre::retrieveByField('id', $_GET['id'], SimpleOrm::FETCH_ONE);
    if ($chapitre_trouve === null)
        redirection('404', 'Ce chapitre n\'existe pas.');

    $saison_parent = saison_trouve_par_id($chapitre_trouve->id_saison);

    // RECUPERATION des données annexes
    $chapitre_enfants = chapitres_enfants_de_saison_tries_numero($saison_parent->id);
    $tous_les_chapitres = Chapitre::all();
    $toutes_les_saisons = Saison::all();

    // RECUPERATION des utilisateurs
    require_once DOSSIER_MODELS . '/Utilisateur.php';
    $utilisateurs = Utilisateur::all();
    
    // AFFICHAGE
    $html_title = 'Modifier un chapitre' .  ' | Administration de ' . NOM_DU_SITE;
    $h1 = 'Modifier un chapitre';
    include_once DOSSIER_VIEWS . '/admin/modifier-chapitre.html.php';
}

function admin_modifier_chapitre_handler() {
    // Gère les données postées du forumlaire pour modifier un chapitre

    // VERIFIFACTION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!'); // VERIF Admin Connecté

    // VERIFICATION des données postées
    if (
        empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1
        || empty($_POST['numero']) || !is_numeric($_POST['numero']) || $_POST['numero'] < 1
        || empty($_POST['id_saison']) || !is_numeric($_POST['id_saison']) || $_POST['id_saison'] < 1
        || empty($_POST['titre']) || is_numeric($_POST['titre'])
        || empty($_POST['citation']) || is_numeric($_POST['citation'])
        || empty($_POST['couleur'])
        || empty($_POST['id_mj']) || !is_numeric($_POST['id_mj']) || $_POST['id_mj'] < 1
        ) redirection('admin-modifier-chapitre' . '&id=' . $_GET['id'], 'Informations postées manquantes ou invalides', 'warning');
  
    // RECUPERATION DES DONNEES
    $chapitre_trouve = chapitre_trouve_par_id($_GET['id']);
    $saison_parent = saison_trouve_par_id($chapitre_trouve->id_saison);

    // GESTION de l'image (qui est facultative donc la valeur null est autorisée)
    if (verif_image() === false)
        redirection('admin-modifier-chapitre' . '&id=' . $_GET['id'],
                    'Image invalide, veuillez réessayer avec un format ou taille appropriées', 'warning');
    elseif (verif_image() === null)
        $image_nouvel_url = $chapitre_trouve->image;
    else
        $image_nouvel_url = uploader_image($saison_parent->numero, $chapitre_trouve->numero, 0, 0, $chapitre_trouve->image);
    
    // GESTION de la position / numero
    if ($chapitre_trouve->numero != $_POST['numero'] || $chapitre_trouve->id_saison != $_POST['id_saison'])
        reordonner_fratrie($chapitre_trouve->numero, $_POST['numero'],
                            chapitres_enfants_de_saison($saison_parent->id),
                            chapitres_enfants_de_saison($_POST['id_saison']));

    // SAUVEGARDE des données du Chapitre
    $chapitre_trouve->numero = $_POST['numero'];
    $chapitre_trouve->titre = htmlspecialchars($_POST['titre']);
    $chapitre_trouve->citation = htmlspecialchars($_POST['citation']);
    $chapitre_trouve->image = $image_nouvel_url;
    $chapitre_trouve->id_saison = $_POST['id_saison'];
    $chapitre_trouve->couleur = $_POST['couleur'];
    $chapitre_trouve->id_mj = $_POST['id_mj'];

    $chapitre_trouve->save();

    // Affichage de la VUE
    redirection('aventure&saison=' . $chapitre_trouve->id_saison
                . '&chapitre=' . $chapitre_trouve->numero,
                'Le chapitre a bien été modifié !',
                'success', '', '#tete-lecture-ch' . $chapitre_trouve->numero);
}

function admin_supprimer_chapitre_handler() {
    // Gère la suppression du chapitre demandé

    // VERIFIFACTION si Administrateur est connecté
    if (!admin_connecte()) redirection('403', 'Accès non-autorisée!');
    
     // VERIFICATION du paramètre URL GET
    if (empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1)
        redirection('500', 'Informations manquantes ou invalides pour le traitement interne dans le serveur');

    $chapitre_trouve = chapitre_trouve_par_id($_GET['id']);
    $saison_parent = saison_trouve_par_id($chapitre_trouve->id_saison);

    if (episodes_enfants_du_chapitre($_GET['id']))
        redirection('aventure&saison=' . $saison_parent->numero,
                    'Ce chapitre a des épisodes enfants, veuillez les supprimer au préalable',
                    'danger', '', '#tete-lecture-ch' . $chapitre_trouve->numero);

    supprimer_image($chapitre_trouve->image, 'chapitres/');

    // GESTION de la position / numero
    reordonner_fratrie($chapitre_trouve->numero, -1, chapitres_enfants_de_saison($chapitre_trouve->id_saison), []);

    $chapitre_trouve->delete();

    // AFFICHAGE de la VUE
    if (!empty($_GET['depuis'])) redirection($_GET['depuis'], 'Le chapitre a bien été supprimé !');
    else redirection('aventure' . '&saison=' . $saison_parent->numero , 'Le chapitre a bien été supprimé !', 'success');
}

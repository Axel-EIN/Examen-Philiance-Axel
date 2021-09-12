<?php

// IMPORT => Fichier config, constantes, SimpleOrm et fonctions
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/SimpleOrm.class.php';
require_once __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/view-functions.php';

$connexion_mysqli = new mysqli(BDD_HOTE, BDD_UTILISATEUR, BDD_MDP); // CREATION => Connexion BDD mysqli
if ($connexion_mysqli->connect_error) redirection('500');

SimpleOrm::useConnection($connexion_mysqli, BDD_NOM); // UTILISATION => Connexion BDD

// DEMARRAGE => Session & Cookie
session_start();
reconnexion_via_cookie();

if (!empty($_GET['page'])) { // VERIF => paramètre URL GET 'page' pour pouvoir router

    switch ($_GET['page']) {
        case 'home':
        case 'index':
        case 'accueil':
        case 'saison':
        case 'aventure':
            require_once DOSSIER_CONTROLLERS . '/aventure-controller.php';
            afficher_aventure();
            break;

        case 'episode':
            require_once DOSSIER_CONTROLLERS . '/episode-controller.php';
            afficher_episode();
            break;

        // case 'empire':
        //     include_once DOSSIER_VIEWS . '/empire.html.php';
        //     break;

        // case 'regles':
        //     include_once DOSSIER_VIEWS . '/regles.html.php';
        //     break;

        case 'se-connecter':
            require_once DOSSIER_CONTROLLERS . '/utilisateur-controller.php';
            afficher_formulaire_se_connecter();
            break;

        case 'se-connecter-handler':
            require_once DOSSIER_CONTROLLERS . '/utilisateur-controller.php';
            se_connecter_handler();
            break;
        
        case 'se-deconnecter':
            require_once DOSSIER_CONTROLLERS . '/utilisateur-controller.php';
            se_deconnecter();
            break;

        case 'administration':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            afficher_panneau_administration();
            break;

        // ADMIN SCENES

        case 'admin-modifier-scene':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_modifier_scene();
            break;

        case 'admin-modifier-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_modifier_scene_handler();
            break;

        case 'admin-creer-scene':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_creer_scene();

        case 'admin-creer-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_creer_scene_handler();

        case 'admin-supprimer-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_supprimer_scene_handler();

        // ADMIN EPISODE

        case 'admin-modifier-episode':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_modifier_episode();
            break;

        case 'admin-modifier-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_modifier_episode_handler();
            break;

        case 'admin-creer-episode':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_creer_episode();

        case 'admin-creer-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_creer_episode_handler();

        case 'admin-supprimer-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/administration-controller.php';
            admin_supprimer_episode_handler();

        case '500':
            page_erreur('500','Problème internet au serveur!');
            break;

        case '403':
            page_erreur('403','Accès interdit!');
            break;

        case '404':
        default:
            page_erreur('404','Cette page est introuvable!');
            break;
    }
    
} else
    redirection('accueil');


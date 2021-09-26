<?php

// IMPORT => Fichier config, constantes, SimpleOrm et fonctions
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/SimpleOrm.class.php';
require_once __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/view-functions.php';

$connexion_mysqli = new mysqli(BDD_HOTE, BDD_UTILISATEUR, BDD_MDP); // CREATION => Connexion BDD mysqli
if ($connexion_mysqli->connect_error) redirection('500', 'Erreur Interne au serveur!');

SimpleOrm::useConnection($connexion_mysqli, BDD_NOM); // UTILISATION => Connexion BDD

$connexion_mysqli->set_charset('utf8'); // Force la configuration de MySLI en UTF-8

// DEMARRAGE => Session & Cookie
session_start();
reconnexion_via_cookie();

if (!empty($_GET['page'])) {
    // VERIF => paramètre URL GET 'page' pour pouvoir router

    switch ($_GET['page']) {
        case 'home':
        case 'index':
        case 'accueil':
        case 'saison':

        /**
         * AVENTURE
         */
        case 'aventure':
            require_once DOSSIER_CONTROLLERS . '/aventure-controller.php';
            afficher_aventure();
            break;

        case 'episode':
            require_once DOSSIER_CONTROLLERS . '/aventure-controller.php';
            afficher_episode();
            break;

        /**
         * CONNEXION
         */
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


        /**
         * ADMIN SCENES
         */
        case 'administration':
        // case 'administration-scenes':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            afficher_panneau_administration_scenes();
            break;

        case 'admin-creer-scene':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            admin_creer_scene();
            break;

        case 'admin-creer-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            admin_creer_scene_handler();
            break;

        case 'admin-modifier-scene':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            admin_modifier_scene();
            break;

        case 'admin-modifier-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            admin_modifier_scene_handler();
            break;

        case 'admin-supprimer-scene-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-scenes-controller.php';
            admin_supprimer_scene_handler();
            break;


        /**
         * ADMIN EPISODES
         */
        case 'administration-episodes':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            afficher_panneau_administration_episodes();
            break;

        case 'admin-creer-episode':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            admin_creer_episode();
            break;

        case 'admin-creer-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            admin_creer_episode_handler();
            break;

        case 'admin-modifier-episode':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            admin_modifier_episode();
            break;

        case 'admin-modifier-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            admin_modifier_episode_handler();
            break;

        case 'admin-supprimer-episode-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-episodes-controller.php';
            admin_supprimer_episode_handler();
            break;


        /**
         * ADMIN CHAPITRES
         */
        case 'administration-chapitres':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            afficher_panneau_administration_chapitres();
            break;

        case 'admin-creer-chapitre':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            admin_creer_chapitre();
            break;

        case 'admin-creer-chapitre-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            admin_creer_chapitre_handler();
            break;

        case 'admin-modifier-chapitre':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            admin_modifier_chapitre();
            break;

        case 'admin-modifier-chapitre-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            admin_modifier_chapitre_handler();
            break;

        case 'admin-supprimer-chapitre-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-chapitres-controller.php';
            admin_supprimer_chapitre_handler();
            break;

        // ADMIN SAISONS
        case 'administration-saisons':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            afficher_panneau_administration_saisons();
            break;

        case 'admin-creer-saison':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            admin_creer_saison();
            break;

        case 'admin-creer-saison-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            admin_creer_saison_handler();
            break;

        case 'admin-modifier-saison':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            admin_modifier_saison();
            break;

        case 'admin-modifier-saison-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            admin_modifier_saison_handler();
            break;

        case 'admin-supprimer-saison-handler':
            require_once DOSSIER_CONTROLLERS . '/admin-saisons-controller.php';
            admin_supprimer_saison_handler();
            break;


        /**
         * PAGE ERREURS
         */
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


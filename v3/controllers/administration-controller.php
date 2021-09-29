<?php

    // IMPORTATION des modèles des données
    // require_once DOSSIER_MODELS . '/Chapitre.php';
    // require_once DOSSIER_MODELS . '/Episode.php';
    // require_once DOSSIER_MODELS . '/Saison.php';
    // require_once DOSSIER_MODELS . '/Scene.php';

function afficher_panneau_administration() {
    // construit et affiche la page Administration

    // RECUPERATION données

    // AFFICHAGE
    $html_title = 'Administration' .  ' | ' . NOM_DU_SITE;
    $h1 = 'Panneau d\'Administration';
    include_once DOSSIER_VIEWS . '/admin/admin.html.php';
}
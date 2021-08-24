<?php
include __DIR__ . '/connexion_bdd.php';
include __DIR__ . '/fonctions.php';
include __DIR__ . '/modeles.php';

$episodes = Episodes::all();
$chapitres= Chapitres::all();
$saisons= Saisons::all();
$scenes= Scenes::all();

foreach($chapitres as $chapitre)
{
    echo entete($chapitre->titre) . '<br/>';
}

?>
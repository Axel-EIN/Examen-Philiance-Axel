<?php

function asset($name) {
	return __DIR__ . '' . $name;
}

function couleur_hexa_plus_sombre_rgb(string $couleur, int &$rouge, int &$vert, int &$bleu, int $palier)
{
    // Convertion de la couleur hexadecimal en valeur RGB
    $hex = '#' . $couleur;
    list($eouge, $vert, $bleu) = sscanf($hex, "#%02x%02x%02x");

    // Puis assombrissement via soustraction par palier
    $rouge = max($rouge - $palier, 0);
    $vert = max($vert - $palier, 0);
    $bleu = max($bleu - $palier, 0);
}

function afficher_une_scene(object $scene)
{
    $scene_numero = $scene->numero;
    $numero_episode = $scene->num_episode;
    $numero_chapitre = $scene->num_chapitre;
    $numero_saison = $scene->num_saison;
    $scene_titre = $scene->titre;
    $scene_temps = $scene->temps;
    $scene_image = $scene->image;
    $scene_texte = $scene->texte;
    include __DIR__ . '/afficher_une_scene.php';
}

function afficher_un_chapitre(object $chapitre, array $episodes)
{
    $numero_chapitre = $chapitre->numero;
    $numero_saison = $chapitre->num_saison;
    $titre_chapitre = $chapitre->titre;
    $entete_chapitre = entete($chapitre->titre);
    $citation_chapitre = $chapitre->citation;
    $image_chapitre = $chapitre->image;
    $couleur_chapitre = $chapitre->couleur;
    $mj_chapitre = $chapitre->mj;
    include __DIR__ . '/afficher_un_chapitre.php';
}

function afficher_une_carte_episode(object $episode)
{
    $titre_episode = $episode->titre;
    $numero_episode = $episode->numero;
    $resume_episode = $episode->resume;
    $image_episode = $episode->image;
    $numero_chapitre = $episode->num_chapitre;
    include __DIR__ . '/afficher_une_carte_episode.php';
}

function entete(string $entete):string 
{
    $search = ' à ';
    $replace = '<span class=petit> &nbsp;à&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'Le ';
    $replace = '<span class=petit>Le&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' le ';
    $replace = '<span class=petit> &nbsp;le&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'La ';
    $replace = '<span class=petit>La&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' la ';
    $replace = '<span class=petit> &nbsp;la&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'Les ';
    $replace = '<span class=petit>Les&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' les ';
    $replace = '<span class=petit> &nbsp;les&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'Du ';
    $replace = '<span class=petit>Du&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' du ';
    $replace = '<span class=petit> &nbsp;du&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'De ';
    $replace = '<span class=petit>De&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' de ';
    $replace = '<span class=petit> &nbsp;de&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'Des ';
    $replace = '<span class=petit>Des&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' des ';
    $replace = '<span class=petit> &nbsp;des&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'Dans ';
    $replace = '<span class=petit>Dans&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = ' dans ';
    $replace = '<span class=petit> &nbsp;dans&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    $search = 'l\'';
    $replace = '<span class=petit>l\'&nbsp; </span>';
    $entete = str_replace($search,$replace,$entete);

    return $entete;
}

?>
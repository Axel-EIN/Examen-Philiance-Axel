<?php

// FONCTION => Cette fonction prend une chaîne de caractère et la stylise en ajoutant des balises span
// sur les determinants et les mot de liaisons
// ENTREES => Elle prend en paramètre une chaîne de caractères
function titre_stylise(string $titre):string {

    // $tableau['à', 'le', 'du'];
    // $tableau['']
    // $tableau2 = [];
    // $tableau_replace = [];
    // foreach($tableau as $mot) {
    //     $tableau2[] = $mot;
    //     $tableau2[] = ucfirst($mot);
    //     $tableau2[] = $mot . ' ';
    //     $tableau2[] = ucfirst($mot) . ' ';
    //     $tableau2[] = ' ' . $mot;
    //     $tableau2[] = ' ' . ucfirst($mot);

    //     $tableau_replace[] = '<span class=petit>' . $mot . ' .</span>';
    // }

    // $titre = str_replace($tableau2, $tableau_replace, $titre);

    $search = ' à ';
    $replace = '<span class=petit> &nbsp;à&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'Le ';
    $replace = '<span class=petit>Le&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' le ';
    $replace = '<span class=petit> &nbsp;le&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'La ';
    $replace = '<span class=petit>La&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' la ';
    $replace = '<span class=petit> &nbsp;la&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'Les ';
    $replace = '<span class=petit>Les&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' les ';
    $replace = '<span class=petit> &nbsp;les&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'Du ';
    $replace = '<span class=petit>Du&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' du ';
    $replace = '<span class=petit> &nbsp;du&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'De ';
    $replace = '<span class=petit>De&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' de ';
    $replace = '<span class=petit> &nbsp;de&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'Des ';
    $replace = '<span class=petit>Des&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' des ';
    $replace = '<span class=petit> &nbsp;des&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'Dans ';
    $replace = '<span class=petit>Dans&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = ' dans ';
    $replace = '<span class=petit> &nbsp;dans&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    $search = 'l\'';
    $replace = '<span class=petit>l\'&nbsp; </span>';
    $titre = str_replace($search,$replace,$titre);

    return $titre;
}


// FONCTION => Permet à partir d'une couleur en hexadecimale d'obtenir une version plus sombre en RGB
// ENTREES => A besoin de la couleur à traiter, et des base de couleur rouge, vert, bleu, ainsi qu'un palier d'assombrissement
function couleur_hexa_plus_sombre_rgb(string $couleur, int &$rouge, int &$vert, int &$bleu, int $palier) {
    // Convertion de la couleur hexadecimal en valeur RGB
    $hex = '#' . $couleur;
    list($eouge, $vert, $bleu) = sscanf($hex, "#%02x%02x%02x");

    // Puis assombrissement via soustraction par palier
    $rouge = max($rouge - $palier, 0);
    $vert = max($vert - $palier, 0);
    $bleu = max($bleu - $palier, 0);
}

/**
 * Increases or decreases the brightness of a color by a percentage of the current brightness.
 *
 * @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
 * @param   float   $adjustPercent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
 *
 * @return  string
 *
 * @author  maliayas
 */
function adjustBrightness($hexCode, $adjustPercent) {
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as & $color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}   
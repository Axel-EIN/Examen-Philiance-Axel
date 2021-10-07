<?php

function titre_stylise(string $titre):string {
    // Cette fonction prend une chaîne de caractère et la stylise en ajoutant des balises span
    // qui vont réduire la taille des determinants et des mot de liaisons

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

    // IDEE pour la VERSION AMELIORÉE avec des tableaux de matchs
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
}

function couleur_hexa_plus_sombre_rgb(string $couleur, int &$rouge, int &$vert, int &$bleu, int $palier) {
    // Fonction qui permet à partir d'une couleur hexadecimal d'obtenir une version RGB plus sombre

    // Convertion de la couleur hexadecimal en valeur RGB
    $hex = '#' . $couleur;
    list($eouge, $vert, $bleu) = sscanf($hex, "#%02x%02x%02x");

    // Assombrissement via soustraction par palier
    $rouge = max($rouge - $palier, 0);
    $vert = max($vert - $palier, 0);
    $bleu = max($bleu - $palier, 0);
}

function retirer_liens_personnages(string $texte): string {
    // Cette fonction permet d'enlever les balises liens et images sur un texte d'une scène et remet les balises []

    $nouveau_texte = preg_replace( '#<a .*><img .*/> (.*)<\/a>#Ui', '[$1]', $texte);
    // $1 sert a récupérer le contenu de la première paire de paranthèse capturante du match actuel pour éviter d'en faire d'autre

    return $nouveau_texte;
}

function ajouter_liens_personnages(string $texte): string {
    // Cette fonction parse le texte et ajoute les liens et images pour les personnages trouvées

    $tableau = [];
    preg_match_all('#\[(.*)\]#Ui', $texte, $tableau); // Caputre tout les mots entre [ ]
    $tableau_de_regexp = array_fill(0, count($tableau[1]), '#\[(.*)\]#Ui'); // On crée un tableau de regexp au nbr de matchs

    // Recherche les perosnnages et crée le tableau de remplacement
    require_once DOSSIER_MODELS . '/Personnage.php';
    $tableau_remplacement = [];
    foreach ($tableau[1] as $key => $un_match) {

        if (!($perso_trouve = recuperer_un_personnage_par_prenom($un_match))) {
            redirection('500', 'Personnage ' . $un_match .  ' non-trouvé, veuillez réessayer', 'warning');

            // AMELIORATION POSSIBLE : 
            // unset($tableau[1][$key]);
            // continue; // permet de passer au tour de boucle suivant sans lire la suite du code
            // Faire plutôt une logique avec str_replace SI le perso est trouvé OU bien array_map
            // (le truc avec la fonction car on met le nom du perso dedans)
        }

        $tableau_remplacement[] = '<a class="perso-img" href="' . route('profil-personnage&id=' . $perso_trouve->id) . '">'
                                  . '<img src="' . url_img($perso_trouve->icone) . '" alt="Icône du personnage" /> '
                                  . $perso_trouve->prenom . '</a>';
    }

    return preg_replace( $tableau_de_regexp, $tableau_remplacement, $texte, 1);
    // Attention, si le second paramètre est un tableau, le 1er doit être aussi un tableau, c'est pour ça qu'on utilise le tableau de regexp
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
function adjustBrightness(string $hexCode, float $adjustPercent): string {
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
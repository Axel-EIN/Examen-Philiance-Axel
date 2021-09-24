<?php

function url_img($chemin = '') {
    // Renvoi le chemin des URL pour les images
    return URL_DU_SITE . '/assets/img/' . $chemin;
}

function route(string $nom_route, string $provenance = ''): string {
    // CREE une URL à partir du nom d'une route

    if (!empty($provenance)) $provenance = '&depuis=' . $provenance;

	return URL_DU_SITE . '/index.php?page=' . $nom_route . $provenance;
}

function redirection(string $route_de_destination, string $alerte = '', string $type = '', string $ancre = '', string $cible = '') {
    // Cette fonction redirige vers une nouvelle route. On peut ajouter :
    // - une string pour les messages d'alertes et leur type bootstrap (Success, Warning, Primary, Danger...)
    // - une string pour ajouter une ancre à la fin de l'URL
    // - une cible au cas où on a besoin d'ajouter un paramètre pour cibler quelque chose

    $alerte = '&alerte=' . $alerte;
    $type = '&type=' . $type;
    $cible = '&cible=' . $cible;

    header('location: ' . route($route_de_destination) . $alerte . $type . $cible . $ancre);
    die();
}

function page_erreur(string $nom_de_la_route, string $message) {
    $html_title = 'Erreur ' . $nom_de_la_route . ' | ' . NOM_DU_SITE;
    $h1 = 'Erreur ' . $nom_de_la_route;
    $message_erreur = 'Erreur ' . $nom_de_la_route . ' ! ' . $message;
    include_once DOSSIER_VIEWS .'/erreur.html.php';
}

function reconnexion_via_cookie() {
    // Reconnecte l'Utlisateur si un cookie existe et le met à jour d'un mois

	if (!utilisateur_connecte() && !empty($_COOKIE['identifiant'])) {
		require_once __DIR__ . './../models/Utilisateur.php';
		$utilisateur_trouve = Utilisateur::retrieveByField('identifiant', $_COOKIE['identifiant'], SimpleOrm::FETCH_ONE);

		if ($utilisateur_trouve !== null) {
            $_SESSION['identifiant'] = $utilisateur_trouve->identifiant;
            $_SESSION['role'] = $utilisateur_trouve->role;
            setcookie('identifiant', $utilisateur_trouve->identifiant, time() + 30 * 24 * 3600);
		}
	}
}

function utilisateur_connecte(): bool {
    // VERIFIE si un Utilisateur est connécté
    if (!empty($_SESSION['identifiant'])) return true;
	else return false; 
}

function admin_connecte(): bool {
    // VERIFIE si un Admin est connecté
    if (utilisateur_connecte()) { if (!empty($_SESSION['role']) && $_SESSION['role'] == 'admin') return true; }
    return false;
}

function verif_image() {
    // VERIFIE si une image est valide
    // ANCIENNE IMAGE = false, on peut mettre true pour demander une suppression dans le cas d'edition d'une image

    if (empty($_FILES['image']['name']) || empty($_FILES['image']['tmp_name']))
        return null; // renvoi null pour signifier qu'aucune image n'est disponible dans $_FILES

    if ($_FILES['image']['error'] != 0
        || $_FILES['image']['size'] >= 5_000_000
        || substr($_FILES['image']['type'], 0, 5) != 'image')
        return false; // renvoi false pour signifier que l'image est invalide ou qu'une erreur s'est produite

    return true;
}

function uploader_image(int $saison, int $chapitre, int $episode, int $scene, string $ancienne_image = '') {
    // ON RECOIT les numeros pour identifier la Saison, le Chapitre, l'Episode, la Scène, on renvoi un URL pour l'image uploadée
    // ANCIENNE IMAGE = false, on peut mettre true pour demander une suppression dans le cas d'edition d'une image

    // CREATION du FICHIER image a stoker sur le serveur
    $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    // GESTION du NOM du fichier et son EMPLACEMENT de stockage
    if ($scene != 0) {
        $image_nouveau_nom = 's' . $saison . '-ch' . $chapitre . '-ep' . $episode . '-scene' . $scene . '-' . uniqid() . '.' . $image_extension;
        $image_chemin = DIR_IMG . '/' . 'scenes/' . $image_nouveau_nom;
        $dossier_categorie = 'scenes/';
    } elseif ($episode != 0) {
        $image_nouveau_nom = 's' . $saison . '-ch' . $chapitre . '-ep' . $episode . '-' . uniqid() . '.' . $image_extension;
        $image_chemin = DIR_IMG . '/' . 'episodes/' . $image_nouveau_nom;
        $dossier_categorie = 'episodes/';
    } elseif ($chapitre != 0) {
        $image_nouveau_nom = 's' . $saison . '-ch' . $chapitre . '-' . uniqid() . '.' . $image_extension;
        $image_chemin = DIR_IMG . '/' . 'chapitres/' . $image_nouveau_nom;
        $dossier_categorie = 'chapitres/';
    } elseif ($saison != 0) {
        $image_nouveau_nom = 's' . $saison . '-' . uniqid() . '.' . $image_extension;
        $image_chemin = DIR_IMG . '/' . 'saisons/' . $image_nouveau_nom;
        $dossier_categorie = 'saisons/';
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_chemin))
        redirection('500', 'Erreur Interne, l\'image n\'a pas pu être sauvegardé sur le serveur');    

    if ($ancienne_image != '') // Si une ancienne image existe on va aller la supprimer    
        supprimer_image($ancienne_image, $dossier_categorie);

    // CONSTRUCTION de l'URL du nouvel fichier image
    $image_nouvel_url = $dossier_categorie . $image_nouveau_nom;
    return $image_nouvel_url;
}

function supprimer_image(string $url_image, string $dossier_categorie): bool {
    // Cette fonction supprime l'image du serveur

    $nom_fichier_a_supprimer = basename($url_image);
    
    $chemin_du_fichier_a_supprimer = DIR_IMG . '/' . $dossier_categorie . $nom_fichier_a_supprimer;
    if (file_exists($chemin_du_fichier_a_supprimer)) unlink($chemin_du_fichier_a_supprimer);
    else return false;

    return true;
}

function reordonner_fratrie(int $position_depart, int $position_arrivee, array $fratrie_depart, array $fratrie_arrivee) {

     // INSERTION = CREATION Scène et INSERTION dans épisode différent
    if ($position_depart < 0 || $fratrie_depart != $fratrie_arrivee)
    {
        // Pour faire une place, on INCREMENTE numéros scènes qui finiront derrière
        foreach($fratrie_arrivee as &$une_scene_arrivee) { 
            if ($une_scene_arrivee->numero >= $position_arrivee) {
                $une_scene_arrivee->numero += 1;
                $une_scene_arrivee->save();
            }
        }
    }

    // DESINSERTION = SUPPRESSION Scène et DESINSERTION de épisode d'origine
    if($position_arrivee < 0 || $fratrie_depart != $fratrie_arrivee)
    {
        // Pour combler le vide, on DECREMENTE numéros scènes qui étaient postérieurs
        foreach($fratrie_depart as &$une_scene) {
            if ($une_scene->numero > $position_depart) {
                $une_scene->numero -= 1;
                $une_scene->save();
            }
        }
    }

    // CHANGEMENT POSITION = dans le même épisode
    if ($fratrie_depart == $fratrie_arrivee)
    {
        // Si la position avance, on recule scènes égales et postérieurs
        if ($position_arrivee < $position_depart) {
            foreach($fratrie_depart as &$une_scene) {
                if ($une_scene->numero >= $position_arrivee && $une_scene->numero < $position_depart) {
                    $une_scene->numero += 1;
                    $une_scene->save();
                }
            }
        // Si la position récule, on avance scènes égales et antérieurs
        } elseif ($position_arrivee > $position_depart) {
            foreach($fratrie_depart as &$une_scene) {
                if ($une_scene->numero <= $position_arrivee && $une_scene->numero > $position_depart) {
                    $une_scene->numero -= 1;
                    $une_scene->save();
                }
            }
        }
    }
}
<?php

require_once DOSSIER_MODELS . '/Utilisateur.php';

function afficher_formulaire_se_connecter() {

    // AFFICHAGE
    $html_title = 'Connexion' . ' | ' . NOM_DU_SITE;
    $h1 = 'Connexion';
    include_once DOSSIER_VIEWS . '/se-connecter.html.php';
}

function se_connecter_handler() { 
    // VERIFICATION DES DONNEES POST
    if (!empty($_POST['identifiant']) && !is_numeric($_POST['identifiant'])
        && !empty($_POST['mdp'])) {

        $utilisateur_trouve = Utilisateur::retrieveByField('identifiant', $_POST['identifiant'], SimpleOrm::FETCH_ONE);
        if ($utilisateur_trouve === null) { // Si la recherche null on renvoit vers formulaire avec une alerte
            redirection('se-connecter', 'Cette utilisateur n\'existe pas !', 'warning');
        } else {
            // Sinon on compare le mot de passe saisi avec celui hashé en BDD
            if (!password_verify($_POST['mdp'], $utilisateur_trouve->mdp))
                redirection('se-connecter', 'Mot de passe incorrect ! Veuillez réessayer.', 'danger');
            else { // Si c'est bon on crée la session puis le cookie
                $_SESSION['id'] = $utilisateur_trouve->id;
                $_SESSION['identifiant'] = $utilisateur_trouve->identifiant;
                $_SESSION['prenom'] = $utilisateur_trouve->prenom;
                $_SESSION['image'] = $utilisateur_trouve->image;
                $_SESSION['role'] = $utilisateur_trouve->role;

                if (!empty($_POST['rester_connecte']) && $_POST['rester_connecte'] == 'true')
                    setcookie(
                        'identifiant', // on crée ou recrée un cookie qui a pour clé identifiant
                        $utilisateur_trouve->identifiant, // la valeur sera l'identifiant de l'utilisateur qu'on vient de connecter
                        time() + 30 * 24 * 3600 // On met une date d'expiration d'un mois
                    );

                redirection('aventure', 'Connexion résussie !');
            }
        }
    } else // Erreur : je renvoie sur le formulaire de connexion avec un message d'alerte
        redirection('se-connecter', 'Le formulaire est invalide !', 'danger');
}

function se_deconnecter() {
    session_destroy();

    setcookie('identifiant', '', -1); // on détruit le cookie en le faisant expirer

	redirection('accueil', 'Déconnexion réussie !');
}

function afficher_mon_compte() {
    // VERIF
    if(!utilisateur_connecte()) redirection('403', 'Désolé ! Veuillez-vous connecter !');

    if(empty($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1 ) redirection('500', 'Erreur Interne au serveur !');

    if($_GET['id'] != $_SESSION['id']) redirection('403', 'Vous n\'êtes pas autorisé à accéder aux informations des autres!');

    // DONNEES
    $utilisateur_trouve = recuperer_un_utilisateur($_GET['id']);
    require_once DOSSIER_MODELS . '/Personnage.php';
    $personnages_utilisateur = recuperer_personnages_de_utilisateur($utilisateur_trouve->id);

    // AFFICHAGE
    $html_title = 'Mon compte' . ' | ' . NOM_DU_SITE;
    include_once DOSSIER_VIEWS . '/mon-compte/accueil-mon-compte.html.php';
}
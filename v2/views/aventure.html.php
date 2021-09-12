<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<?php
    afficher_saison_header($saison_trouve, $saisons);
    afficher_liste_chapitres($saison_trouve->id);
?>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

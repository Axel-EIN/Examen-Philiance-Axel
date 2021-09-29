<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER SAISON -->
<?php include_once DOSSIER_VIEWS . '/aventure/parts/header-saison.html.php'; ?>

<!-- AFFICHAGE DES CHAPITRES DE LA SAISON -->
<main>
    <div class="pt-4" style="background-color: <?= $saison_trouve->couleur; ?>;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="display-4 text-center pb-3 text-light">Liste des Chapitres</h2>
                </div>
            </div>
        </div>
    </div>
    
    <?php $numero = 0; if(empty($chapitres)): ?>
        <!-- SEPARATEUR + BOUTON INSERER si ADMIN -->
        <div class="chapitre-separateur text-center">
            <div class="alert alert-light mx-auto persistante mt-3 mb-0">
                <strong>Désolé il n'y a pas encore de Chapitres disponible !</strong>
            </div>
            <?php if(admin_connecte()) include DOSSIER_VIEWS . '/boutons/inserer-chapitre.html.php'; ?>
        </div>
    <?php else: ?>

        <!-- SEPARATEUR + BOUTON INSERER si ADMIN -->
        <div class="chapitre-separateur text-center">
            <?php if(admin_connecte()) include DOSSIER_VIEWS . '/boutons/inserer-chapitre.html.php'; ?>
        </div>

        <?php foreach ($chapitres as $chapitre): ?>
            <?php $r = 0; $g = 0; $b = 0; ?>
            <?php couleur_hexa_plus_sombre_rgb($chapitre->couleur, $r, $g, $b, 30); ?>
            <?php if(!empty($_GET['chapitre']) && $_GET['chapitre'] == $chapitre->numero) {
                    $volet = 'ouvert';
                    $bouton = 'cacher';
                    $btn_txt = 'Replier';
                    } else {
                    $volet = 'fermer';
                    $bouton = 'voir';
                    $btn_txt = 'Voir les Episodes'; } ?>
            
            <?php include DOSSIER_VIEWS . '/aventure/parts/header-chapitre.html.php'; ?>
            <?php include DOSSIER_VIEWS . '/aventure/parts/liste-episodes.html.php'; ?>
                       
                    </div>
                </div>
            </section>

            <div class="chapitre-separateur text-center">
                <?php $numero++; if(admin_connecte()) include DOSSIER_VIEWS . '/boutons/inserer-chapitre.html.php'; ?>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/modal.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

<!-- HEADER GENERAL -->
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER SAISON -->
<?php include_once DOSSIER_VIEWS . '/aventure/parts/header-saison.html.php'; ?>

<!-- AFFICHAGE DES CHAPITRES DE LA SAISON -->
<main>
    <div class="container-fluid" style="background-color: <?= $saison_trouve->couleur; ?>;">
        <div class="container py-3">
            <h2 class="display-4 text-center text-light">Liste des Chapitres</h2>
        </div>
    </div>
    
    <!-- SEPARATEUR -->
    <div class="chapitre-separateur text-center">
        <?php if(admin_connecte()): ?>
            <?php if(empty($chapitres)): ?>
                <div class="alert alert-light mx-auto persistante mt-3 mb-0">
                    <strong>Désolé il n'y a pas encore de Chapitre !</strong>
                </div>
            <?php endif; ?>
            <div class="p-3">
                <a class="text-light"
                href="<?= route('admin-creer-chapitre&id_saison=' . $saison_trouve->id . '&numero=1'); ?>">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;<strong>Insérer un Chapitre</strong>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if(!empty($chapitres)): ?>
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

            <!-- SEPARATEUR -->
            <div class="chapitre-separateur text-center">
                <?php if(admin_connecte()): ?>
                    <div class="p-3">
                        <a class="text-light"
                        href="<?= route('admin-creer-chapitre&id_saison=' . $saison_trouve->id . '&numero=' . ($chapitre->numero + 1)); ?>">
                            <i class="fas fa-plus-square"></i>&nbsp;&nbsp;<strong>Insérer un Chapitre</strong>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</main>

<?php include_once DOSSIER_VIEWS . '/parts/modal.html.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

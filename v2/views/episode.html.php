<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER IMAGE + TITRE DU CHAPITRE -->
<div id="ch<?= $chapitre_parent->numero; ?>-header" class="episode-fond p-md-4" style="background-image: url('<?= $chapitre_parent->image; ?>');background-color: #<?= $chapitre_parent->couleur; ?>;">
    <header class="container">
        <div class="header">
            <h1 class="display-5">CHAPITRE <?= $chapitre_parent->numero; ?></h1>
            <hr class="my-md-2">
            <a class="btn btn-primary btn-lg" href="<?= route('aventure&saison=' . $saison_parent->numero); ?>#ch<?= $chapitre_parent->numero; ?>-header" role="button">Retour au chapitre</a>
            <p class="lead grand" id="tete-lecture">
                <?= titre_stylise($chapitre_parent->titre); ?>
            </p>
            <p class="citation"><?php echo nl2br($chapitre_parent->citation); ?></p>
        </div>
    </header>

    <!-- RESUME DE L'EPISODE -->
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-xl-10 newpad">
                <div class="card">

                    <!-- ADMIN : MODIFIER / SUPPRIMER -->
                    <?php if(admin_connecte()): ?>
                        <div class="d-flex justify-content-center mt-3">
                            <div class="col-3 text-center">
                                <a href="<?= route('admin-modifier-episode&id=' . $episode_trouve->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Modifier l'Episode</a>
                            </div>
                            <div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="col-3 text-center">
                                <a href="<?= route('admin-supprimer-episode-handler&id=' . $episode_trouve->id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'episode : <?= $episode_trouve->titre ?> ?')"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Supprimer l'Episode</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- FIN ADMIN : MODIFIER / SUPPRIMER -->

                    <!-- NAVIGATION PRECEDENT / SUIVANT -->
                    <section class="d-flex px-3">
                        <!-- EPISODE PRECEDENT -->
                        <?php if (!empty($episode_precedent)) : ?>
                            <div class="pr-1 text-left d-flex flex-column justify-content-center">
                                <a href="<?= route('episode&episode=' . $episode_precedent->numero . '&saison=' . $saison_numero . '#tete-lecture'); ?>" class="btn btn-primary">Episode précédent</a>
                            </div>
                        <?php else: ?>
                            <div class="pr-1 text-left d-flex flex-column justify-content-center">
                                <a href="#" class="btn btn-primary disabled">Episode précédent</a>
                            </div>
                        <?php endif; ?>
                        <div class="pr-1 flex-grow-1 text-left">
                            <h2 class="text-center py-3">
                                <p>
                                    <span class="display-4">- <?= $episode_trouve->numero; ?> -</span>
                                    <br/>
                                    <span><?= $episode_trouve->titre; ?></span>
                                </p>
                            </h2>
                        </div>
                        <!-- EPISODE SUIVANT -->
                        <?php if (!empty($episode_suivant)) : ?>
                            <div class="pr-1 text-left d-flex flex-column justify-content-center">
                                <a href="<?= route('episode&episode=' . $episode_suivant->numero . '&saison=' . $saison_numero . '#tete-lecture'); ?>" class="btn btn-primary">Episode suivant</a>
                            </div>
                        <?php else: ?>
                            <div class="pr-1 text-left d-flex flex-column justify-content-center">
                                <a href="#" class="btn btn-primary disabled">Episode suivant</a>
                            </div>
                        <?php endif; ?>
                    </section>
                    <!-- FIN : NAVIGATION PRECEDENT / SUIVANT -->

                    <!-- ALERTE -->
                    <?php if (!empty($_GET['alerte']) && empty($_GET['scene_id'])): ?>
                        <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Opération réussie!</strong> <?= $_GET['alerte']; ?>
                        </div>
                    <?php endif; ?>
                    <!-- FIN : ALERTE -->

                    <!-- SECTION CORPS DU RESUME : AFFICHAGE DES SCENES -->
                    <section>
                        <?php foreach ($scenes as $scene)
                                include DOSSIER_VIEWS . '/parts/afficher-une-scene.html.php';
                        ?>
                    </section>

                    <!-- SECTION NAVIGATION DU BAS -->
                    <section class="d-flex justify-content-center p-4">
                        <div class="col py0 pl-0 pr-2">
                        </div>
                        <div>
                            <a href="#ch<?= $chapitre_parent->numero; ?>-header" class="btn btn-primary">Retour en haut</a>
                        </div>
                        <?php if (!empty($episode_suivant)) : ?>
                            <div class="col py-0 pr-0 pl-2 text-right">
                                <a href="<?= route('episode&episode=' . $episode_suivant->numero . '&saison=' . $saison_numero . '#tete-lecture'); ?>" class="btn btn-primary">Episode suivant</a>
                            </div>
                        <?php else: ?>
                            <div class="col py-0 pr-0 pl-2 text-right">
                                <a href="#" class="btn btn-primary disabled">Episode suivant</a>
                            </div>
                        <?php endif; ?>
                    </section>

                </div>
            </div>
        </div>
    </main>
</div>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

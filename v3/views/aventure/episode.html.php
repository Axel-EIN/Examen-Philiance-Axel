<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER CHAPITRE : IMAGE + TITRE -->
<div id="ch<?= $chapitre_parent->numero; ?>-header"
    class="episode-fond p-md-4"
    style="background-image: url('<?= url_img($chapitre_parent->image); ?>');background-color: <?= $chapitre_parent->couleur; ?>;">

    <header class="container">
        <div class="header-episode">
            <h2 class="display-5 text-left">CHAPITRE <?= $chapitre_parent->numero; ?></h2>
            <hr>
            <div class="text-left">
                <a class="btn btn-primary btn-lg" href="<?= route('aventure&saison=' . $saison_parent->numero . '&chapitre=' . $chapitre_parent->numero
                                                            . '#tete-lecture-ch' . $chapitre_parent->numero); ?>" role="button">Retour</a>
            </div>
            <h2 class="lead-stylise grand ombre-txt"><?= titre_stylise($chapitre_parent->titre); ?></h2>
            <p class="citation"><?php echo nl2br($chapitre_parent->citation); ?></p>
        </div>
    </header>

    <!-- RESUME DE L'EPISODE -->
    <main id="tete-lecture" class="container pt-3">

    <!-- ADMIN : MODIFIER / SUPPRIMER -->
    <?php if(admin_connecte()): ?>
        <div class="d-flex justify-content-center">
                <a href="<?= route('admin-modifier-episode&id=' . $episode_trouve->id); ?>" class="text-light">
                    <i class="fas fa-edit"></i>&nbsp;&nbsp;Modifier l'épisode</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?= route('admin-supprimer-episode-handler&id=' . $episode_trouve->id); ?>" class="text-light"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'épisode : <?= $episode_trouve->titre ?> ?')">
                    <i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Supprimer l'Episode
                </a>
        </div>
    <?php endif; ?>

        <section class="d-flex pt-3 justify-content-center align-items-center">
            
            <!-- PRECEDENT -->                 
            <div class="d-flex flex-column justify-content-center" style="width: 180px;">
                <?php if (!empty($episode_precedent)): ?>
                    <div class="fond-mask" style="position: relative; border: thick double <?= adjustBrightness($chapitre_parent->couleur, 0.2); ?>; border-radius: 15px;">
                        <a href="<?= route('episode&id=' . $episode_precedent->id . '#tete-lecture'); ?>">
                            <span class="display-4 numero-episode-courant"
                                style="color:white; position: absolute; bottom: 10px; left: 10px; line-height: 1;">
                                    <?= $episode_precedent->numero; ?>
                            </span>
                            <img src="<?= url_img($episode_precedent->image); ?>" alt="<?= $episode_precedent->titre; ?>"
                                 class="img-fluid translucide" style="width: 180px; border-radius: 15px;" />
                        </a>
                    </div>
                <?php elseif (admin_connecte()): ?>
                    <a class="gros-bouton" href="<?= route('admin-creer-episode&id_chapitre=' . $chapitre_parent->id . '&numero=1'); ?>">
                        <div class="card-btn">
                            <?php echo file_get_contents(url_img("icons/plus-square-solid.svg")); ?>
                            <br/><strong>Ajouter épisode</strong>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <!-- CHEVRON LEFT -->
            <div class="d-flex flex-column justify-content-center px-3"
                 style="width:64px; color: <?= adjustBrightness($chapitre_parent->couleur, 0.2); ?>;">
                <?php echo file_get_contents(url_img("icons/chevron-left-solid.svg")); ?>
            </div>

            <!-- COURANT -->
            <div class="d-flex flex-column justify-content-center fond-mask"
                 style="border: thick double <?= adjustBrightness($chapitre_parent->couleur, 0.2); ?>; border-radius: 20px;">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative;">
                        <span class="display-1 numero-episode-courant"
                              style="color:white; position: absolute; bottom: 10px; left: 10px; line-height: 1;">
                                <?= $episode_trouve->numero; ?>
                        </span>
                        <img src="<?= url_img($episode_trouve->image); ?>" alt="<?= $episode_trouve->titre; ?>"
                             class="img-fluid" style="width: 420px; border-radius: 20px;" />
                    </div>
                </div>
            </div>

            <!-- CHEVRON RIGHT -->
            <?php if (!empty($episode_suivant)): ?>
            <a href="<?= route('episode&id=' . $episode_suivant->id . '#tete-lecture'); ?>">
                <div class="d-flex flex-column justify-content-center px-3"
                    style="width:64px; color: <?= adjustBrightness($chapitre_parent->couleur, 0.2); ?>;">
                    <?php echo file_get_contents(url_img("icons/chevron-right-solid.svg")); ?>
                </div>
            </a>
            <?php endif; ?>

            <!-- SUIVANT -->
            <div class="text-left d-flex flex-column justify-content-center" style="width: 180px; position: relative;">
                <?php if (!empty($episode_suivant)): ?>
                    <div class="fond-mask" style="border: thick double <?= adjustBrightness($chapitre_parent->couleur, 0.2); ?>; border-radius: 15px;">
                        <a href="<?= route('episode&id=' . $episode_suivant->id . '#tete-lecture'); ?>">
                            <span class="display-4 numero-episode-courant"
                                  style="color:white; position: absolute; bottom: 10px; left: 10px; line-height: 1;">
                                <?= $episode_suivant->numero; ?>
                            </span>
                            <img src="<?= url_img($episode_suivant->image); ?>" alt="<?= $episode_suivant->titre; ?>"
                                 class="img-fluid translucide" style="width: 180px; border-radius: 15px;" />
                        </a>
                    </div>
                <?php elseif (admin_connecte()): ?>
                <a class="gros-bouton" href="<?= route('admin-creer-episode&id_chapitre=' . $chapitre_parent->id . '&numero=' . $episode_trouve->numero+1); ?>">
                    <div class="card-btn">
                        <?php echo file_get_contents(url_img("icons/plus-square-solid.svg")); ?>
                        <br/><strong>Ajouter épisode</strong>
                    </div>
                </a>
                <?php endif; ?>
            </div>

        </section>
        
        <!-- ALERTE -->
        <?php if(!empty($_GET['id']) && $_GET['id'] == $episode_trouve->id && empty($_GET['scene_id']) ): ?>
            <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
        <?php endif; ?>

        <!-- TITRE EPISODE -->
        <div>
            <h2 class="display-3 text-center titre-episode ombre-txt mb-0 mt-3 py-3" style="position: relative; z-index: 2;">
                <?= $episode_trouve->titre; ?>
            </h2>
        </div>

        <div class="row justify-content-center" style="position: relative; top: -48px; z-index: 1;" >
            <div class="col-sm-12 col-xl-10 newpad">
                <div class="card justify-content-center pt-5" style="min-height: 500px;">

                    <!-- AFFICHAGE DES SCENES -->
                    <section>

                        <?php if (empty($scenes)): ?>
                            <div class="text-center">
                                <img src="<?= url_img('pas-de-scenes.png'); ?>" alt="Il n'y a pas encore de scènes" />
                            </div>
                            <div class="row">
                                <div class="text-secondary mx-auto mb-5">
                                    <h5>Il n'y a pas encore de scènes pour cette épisode !</h5>
                                </div>
                            </div>

                            <!-- ADMIN - BTN - INSERER SCENE -->
                            <?php $numero = 1; if(admin_connecte()) include DOSSIER_VIEWS . '/boutons/inserer-scene.html.php'; ?>

                        <?php else: ?>

                            <!-- ADMIN - BTN - INSERER SCENE -->
                            <?php $numero = 1; if(admin_connecte()) include DOSSIER_VIEWS . '/boutons/inserer-scene.html.php'; ?>

                            <?php foreach ($scenes as $scene) { include DOSSIER_VIEWS . '/aventure/parts/afficher-une-scene.html.php'; } ?>
                            
                        <?php endif; ?>

                        <h2 class="text-center">Classement de l'Episode</h2>
                        <div class="d-flex justify-content-center">
                            <ol class="text-center">
                                <?php foreach($participations_episodes as $une_participation_episode): ?>
                                    <li>
                                        <?= recuperer_un_personnage($une_participation_episode->personnage_id)->prenom; ?>
                                        &nbsp;<strong><?= $une_participation_episode->exp_gagne; ?>xp</strong>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>

                        <div class="d-flex justify-content-between p-3">
                            <?php if (!empty($episode_precedent)): ?>
                                <a href="<?= route('episode&id=' . $episode_precedent->id . '#tete-lecture'); ?>" class="btn btn-primary">Précédent</a>
                            <?php else: ?>
                                <span style="width: 96px"></span>
                            <?php endif; ?>
                            <a href="#ch<?= $chapitre_parent->numero; ?>-header" class="btn btn-primary">Retour en haut</a>
                            <?php if (!empty($episode_suivant)): ?>
                                <a href="<?= route('episode&id=' . $episode_suivant->id . '#tete-lecture'); ?>" class="btn btn-primary">Suivant</a>
                            <?php else: ?>
                                <span style="width: 96px"></span>
                            <?php endif; ?>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </main>
</div>

<?php include_once DOSSIER_VIEWS . '/parts/modal.html.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

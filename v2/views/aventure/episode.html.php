<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER CHAPITRE : IMAGE + TITRE -->
<div id="ch<?= $chapitre_parent->numero; ?>-header"
    class="episode-fond p-md-4"
    style="background-image: url('<?= url_img($chapitre_parent->image); ?>');background-color: #<?= $chapitre_parent->couleur; ?>;">

    <header class="container">
        <div class="header">
            <h1 class="display-5">CHAPITRE <?= $chapitre_parent->numero; ?></h1>
            <hr class="my-md-2">
            <a class="btn btn-primary btn-lg"
                                
                href="<?= route('aventure&saison=' . $saison_parent->numero
                                                            . '&chapitre=' . $chapitre_parent->numero
                                                            . '#tete-lecture-ch' . $chapitre_parent->numero); ?>"
                role="button">Retour au chapitre</a>
            <p class="lead grand" id="tete-lecture">
                <?= titre_stylise($chapitre_parent->titre); ?>
            </p>
            <p class="citation"><?php echo nl2br($chapitre_parent->citation); ?></p>
        </div>
    </header>

    <!-- RESUME DE L'EPISODE -->
    <main class="container mt-4">

    <!-- ADMIN : MODIFIER / SUPPRIMER -->
    <?php if(admin_connecte()): ?>
        <div class="d-flex justify-content-center">
                <a href="<?= route('admin-modifier-episode&id=' . $episode_trouve->id); ?>" class="text-light"><i class="fas fa-edit"></i>&nbsp;&nbsp;Modifier l'Episode</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?= route('admin-supprimer-episode-handler&id=' . $episode_trouve->id); ?>" class="text-light"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'episode : <?= $episode_trouve->titre ?> ?')">
                    <i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Supprimer l'Episode
                </a>
        </div>
    <?php endif; ?>

        <section class="d-flex p-3 justify-content-center align-items-center">
            
            <!-- PRECEDENT -->                 
            <div class="d-flex flex-column justify-content-center" style="width: 180px;">
                <?php if (!empty($episode_precedent)): ?>
                    <a href="<?= route('episode&id=' . $episode_precedent->id . '#tete-lecture'); ?>" class="btn btn-primary" style="border-radius: 5px; box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, .4);">
                    <img src="<?= url_img($episode_precedent->image); ?>" alt="<?= $episode_precedent->titre; ?>" class="img-fluid" style="width: 180px;" /><br/>
                    Episode précédent</a>
                <?php endif; ?>
            </div>

            <!-- CHEVRON LEFT -->
            <div class="d-flex flex-column justify-content-center px-3" style="width:64px; color:white;">
                <?php echo file_get_contents(url_img("icons/chevron-left-solid.svg")); ?>
                <!-- <img src="<?= url_img("icons/chevron-left-solid.svg"); ?>" class="img-fluid" style="width:48px;" /> -->
            </div>

            <!-- COURANT -->
            <div class="d-flex flex-column justify-content-center btn btn-primary" style="box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, .4); border-radius: 5px; cursor: unset;">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative;">
                        <span class="display-1 numero-episode-courant" style="color:white; position: absolute; bottom: 10px; left: 10px; line-height: 1;"><?= $episode_trouve->numero; ?></span>
                        <img src="<?= url_img($episode_trouve->image); ?>" alt="<?= $episode_trouve->titre; ?>" class="img-fluid" style="width: 420px;" />
                    </div>
                </div>
            </div>

            <!-- CHEVRON RIGHT -->
            <div class="d-flex flex-column justify-content-center px-3" style="width:64px; color:white;">
                <?php echo file_get_contents(url_img("icons/chevron-right-solid.svg")); ?>
                <!-- <img src="<?= url_img("icons/chevron-right-solid.svg"); ?>" class="img-fluid mx-3" style="width:48px;" /> -->
            </div>

            <!-- SUIVANT -->
            <div class="text-left d-flex flex-column justify-content-center" style="width: 180px;">
                <?php if (!empty($episode_suivant)) : ?>
                    <a href="<?= route('episode&id=' . $episode_suivant->id . '#tete-lecture'); ?>" class="btn btn-primary" style="border-radius: 5px; box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, .4);">
                    <img src="<?= url_img($episode_suivant->image); ?>" alt="<?= $episode_suivant->titre; ?>" class="img-fluid" style="width: 180px;" /><br/>
                    Episode suivant</a>
                <?php endif; ?>
            </div>

        </section>
        
        <!-- ALERTE -->
        <?php if(!empty($_GET['id']) && $_GET['id'] == $episode_trouve->id && empty($_GET['scene_id']) ): ?>
            <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
        <?php endif; ?>

        <!-- TITRE EPISODE -->
        <div class="mt-2">
            <h2 class="display-3 text-center">
                <span style="font-weight: 300; color: white"><?= $episode_trouve->titre; ?></span>
            </h2>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-sm-12 col-xl-10 newpad">
                <div class="card">

                    <!-- AFFICHAGE DES SCENES -->
                    <section style="min-height: 500px;">

                        <?php if (empty($scenes)): ?>
                            <div class="mx-auto mt-5" style="width: 180px; height: auto; color: #BBBBBB">
                                <?php echo file_get_contents(url_img('icons/image-regular.svg')); ?>
                            </div>
                            <div class="row">
                                <div class="text-secondary mx-auto mb-5">
                                    <h5>Il n'y a pas encore de scènes pour cette épisode!</h5>
                                </div>
                            </div>
                            <!-- ADMIN INSERER SCENE -->
                            <?php include DOSSIER_VIEWS . '/boutons/inserer-scene.html.php'; ?>
                        <?php else: ?>
                            <!-- ADMIN INSERER SCENE -->
                            <?php include DOSSIER_VIEWS . '/boutons/inserer-scene.html.php'; ?>
                            <?php foreach ($scenes as $scene) { include DOSSIER_VIEWS . '/aventure/afficher-une-scene.html.php'; } ?>
                        <?php endif; ?>

                        <div class="text-center pb-3">
                            <a href="#ch<?= $chapitre_parent->numero; ?>-header" class="btn btn-primary mt-3">Retour en haut</a>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </main>
</div>

<?php include_once DOSSIER_VIEWS . '/parts/modal.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

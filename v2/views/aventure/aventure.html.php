<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<!-- HEADER SAISON -->
<?php include_once DOSSIER_VIEWS . '/parts/aventure-header-saison.html.php'; ?>

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
            
            <!-- HEADER CHAPITRE -->
            <section
                id="ch<?= $chapitre->numero; ?>-header"
                class="chapitre-fond <?= $volet ?>"
                style="background-color: <?= $chapitre->couleur; ?>;
                background-image:linear-gradient(
                    rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6),
                    rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0),
                    rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.3),
                    rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6)),
                    url('<?= url_img($chapitre->image); ?>');">

                <div class="container pt-md-4 pt-sm-2 pb-4">
                    
                    <!-- EN TETE TEXTE -->
                    <div style="position: relative;">
                        <div class="header" >
                            <h1 class="display-5">CHAPITRE <?= $chapitre->numero; ?></h1>
                            <hr class="my-md-2">

                            <!-- ADMIN : MODIFIER / SUPPRIMER -->
                            <?php if(admin_connecte()): ?>
                            <small>
                                <div class="d-flex justify-content-end mr-3" style="position: relative; top: -60px;">
                                        <a href="<?= route('admin-modifier-chapitre&id=' . $chapitre->id); ?>" class="text-light">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="<?= route('admin-supprimer-chapitre-handler&id=' . $chapitre->id); ?>" class="text-light"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer le chapitre : <?= $chapitre->titre ?> ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                </div>
                            </small>
                            <?php endif; ?>

                            <p id="tete-lecture-ch<?= $chapitre->numero; ?>" class="lead grand">
                                <?= titre_stylise($chapitre->titre); ?>
                            </p>
                            <p class="citation"><?php echo nl2br($chapitre->citation); ?></p>
                        </div>

                        <!-- ALERTE -->
                        <?php if(!empty($_GET['chapitre']) && is_numeric($_GET['chapitre']) && $_GET['chapitre'] == $chapitre->numero): ?>
                            <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
                        <?php endif; ?>

                        <div class="row">
                            <?php $episodes = episodes_enfants_du_chapitre_triees_numero($chapitre->id); ?>
                            <?php if (!empty($episodes)) : ?>

                            <!-- BOUTON : VOIR LES EPISODES -->
                                <a href="#tete-lecture-ch<?= $chapitre->numero; ?>" class="mx-auto">
                                    <button class="btn btn-primary btn-lg text-center <?= $bouton ?>" type="button" data-toggle="collapse"
                                        data-target="#ch<?= $chapitre->numero; ?>-episodes" aria-controls="ch<?= $chapitre->numero; ?>-episodes"
                                        aria-expanded="true" aria-label="Toggle Chapitre <?= $chapitre->numero; ?> Episodes">
                                            <?= $btn_txt; ?>
                                    </button>
                                </a>

                            <?php else: ?>
                                <div class="alert alert-light mx-auto persistante"
                                    style="background-color: rgba(0, 0, 0, .5);
                                            border-color: rgba(255, 255, 255, .4);">
                                    <strong>Désolé ! Il n'y a pas encore d'épisode disponible !</strong>

                                    <!-- MINI BOUTON : CREER UN EPISODE -->
                                    <?php if(admin_connecte()): ?>
                                        <a href="<?= route('admin-creer-episode&id_chapitre=' . $chapitre->id . '&numero=1'); ?>"
                                           class="pardessus-light ml-2 text-light">
                                            <strong>
                                                <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un épisode
                                            </strong>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <br/>

                        <!-- EPISODES DU CHAPITRE -->
                        <div id="ch<?= $chapitre->numero; ?>-episodes"
                            class="collapse <?php if(!empty($_GET['chapitre']) && $_GET['chapitre'] == $chapitre->numero): ?>show<?php endif; ?>">
                            <div class="container">
                                <div class="row justify-content-center">

                                <?php if(!empty($episodes)): ?>

                                    <!-- CARTE POUR CHAQUE EPISODE -->
                                    <?php foreach ($episodes as $episode): ?>   
                                        <div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
                                            <div class="card liste">
                                                <div class="numero"><?= $episode->numero; ?></div>
                                                <div class="fond-mask">
                                                    <a href="<?= route('episode&id=' . $episode->id); ?>#tete-lecture">
                                                        <img src="<?= url_img($episode->image); ?>" alt="Image de <?= $episode->titre; ?>" class="card-img-top img-fluid" />
                                                    </a>
                                                </div>
                                                <div class="card-body ancre-scene">
                                                    <h5 class="card-title" style="font-size: 1rem;"><?= $episode->titre; ?></h5>
                                                    <p class="card-text"><?= $episode->resume; ?></p>
                                                </div>
                                                <div class="text-center p-2">
                                                    <a href="<?= route('episode&id=' . $episode->id); ?>#tete-lecture" class="btn btn-primary">
                                                        <i class="fab fa-readme"></i>&nbsp;&nbsp;Lire l'épisode
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                <?php endif; ?>

                                <!-- BOUTON AJOUTER UN EPISODE -->
                                <?php if(admin_connecte()): ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
                                        <a class="gros_bouton" href="<?= route('admin-creer-episode&id_chapitre=' . $chapitre->id); ?>">
                                            <div class="card new">
                                                <h4>Ajouter un épisode</h4>
                                                <?php echo file_get_contents(url_img("icons/plus-square-solid.svg")); ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                </div>
                            </div>
                        </div>
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

<!-- HEADER CHAPITRE -->
<section id="ch<?= $chapitre->numero; ?>-header" class="chapitre-fond <?= $volet ?>" style="background-color: <?= $chapitre->couleur; ?>;
    background-image:linear-gradient(rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0),
                                    rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.3),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6)),
                                    url('<?= url_img($chapitre->image); ?>');">

    <div class="container">
        <div class="header d-flex flex-column justify-content-end" >
            <h2 class="pre-titre-chapitre text-left">CHAPITRE <?= $chapitre->numero; ?></h2>
            <div><hr></div>
            <?php if(admin_connecte()): ?> <!-- MODIFIER / SUPPRIMER -->
                <small>
                    <div class="header-btn d-flex justify-content-end mr-3">
                            <a href="<?= route('admin-modifier-chapitre&id=' . $chapitre->id); ?>" class="text-light">
                                <i class="fas fa-edit"></i></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?= route('admin-supprimer-chapitre-handler&id=' . $chapitre->id); ?>" class="text-light"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer le chapitre : <?= $chapitre->titre ?> ?')">
                                <i class="fas fa-trash-alt"></i></a>
                    </div>
                </small>
            <?php endif; ?>

            <div class="mt-auto mb-3">
                <h1 id="tete-lecture-ch<?= $chapitre->numero; ?>" class="lead-stylise grand ombre-txt"><?= titre_stylise($chapitre->titre); ?></h1>
                <p class="citation"><?php echo nl2br($chapitre->citation); ?></p>

                <!-- ALERTE -->
                <?php if(!empty($_GET['chapitre']) && is_numeric($_GET['chapitre']) && $_GET['chapitre'] == $chapitre->numero): ?>
                    <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
                <?php endif; ?>

                <?php $episodes = episodes_enfants_du_chapitre_triees_numero($chapitre->id); ?>

                <?php if (!empty($episodes)): ?><!-- BTN VOIR EPISODES -->
                    <div class="mx-auto mb-2">
                        <a href="#tete-lecture-ch<?= $chapitre->numero; ?>">
                            <button class="btn btn-primary btn-lg text-center <?= $bouton ?>" type="button" data-toggle="collapse"
                                data-target="#ch<?= $chapitre->numero; ?>-episodes" aria-controls="ch<?= $chapitre->numero; ?>-episodes"
                                aria-expanded="true" aria-label="Toggle Chapitre <?= $chapitre->numero; ?> Episodes">
                                    <?= $btn_txt; ?>
                            </button>
                        </a>
                    <div>
                <?php else: ?>
                    <div class="alert alert-light mx-auto persistante">
                        <strong>Pas encore d'épisode disponible !</strong>
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

        </div>

            
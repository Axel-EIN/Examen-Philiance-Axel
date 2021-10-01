<!-- EN TETE -->
<header class="header-fond py-md-4 py-sm-2"
    style="background-image: linear-gradient( rgb(40,0,0,0.5), rgb(40,0,0,0.5) ), url('<?= url_img('empire.jpg'); ?>')">
    <div class="container">
        <div class="volatile"><?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?></div>
        <div class="header">
            <div class="text-center d-flex w-100 justify-content-center align-items-baseline">
                <!-- BOUTON SAISON PRECEDENTE -->
                <div class="fleche text-center p-2 mr-2">
                    <?php if (!empty($saison_precedente)): ?>
                        <a class="text-light" href="<?= route('personnages&saison=' . $saison_precedente->numero); ?>">
                            <?php echo file_get_contents(url_img('icons/chevron-left-solid.svg')); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <!-- SAISON EN COURS -->
                <h2 class="pre-titre-saison">SAISON <?= $saison_trouve->numero ?></h2>
                <!-- BOUTON SAISON SUIVANTE -->
                <div class="fleche text-center p-2 ml-2">
                    <?php if (!empty($saison_suivante)): ?>
                        <a class="text-light" href="index.php?page=personnages&saison=<?= $saison_suivante->numero; ?>">
                            <?php echo file_get_contents(url_img('icons/chevron-right-solid.svg')); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <hr class="w-50">
            <h1 class="lead-stylise grand"><?= titre_stylise('Les Héros <br> de l\'Histoire'); ?></h1>
        </div>
    </div>
</header>
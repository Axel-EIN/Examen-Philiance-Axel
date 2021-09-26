<!-- HEADER SAISON -->
<header id="header-s<?= $saison_trouve->numero; ?>" class="header-fond py-md-4 py-sm-2"
style="background-image: linear-gradient(rgb(40,0,0,0.5),rgb(40,0,0,0.5)),url('<?= url_img($saison_trouve->image); ?>');">
    <div class="container" style="position: relative">

        <?php if (empty($_GET['chapitre'])): ?>
            <div class="volatile" style="position: aboslute; left: 50%; top: -20px; transform: translate(-50%, -50%);">
                <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
            </div>
        <?php endif; ?>

        <div class="header">
            <h1 class="display-5 text-center">
                <div class="d-flex w-100 justify-content-center align-items-baseline">

                    <!-- BOUTON SAISON PRECEDENTE -->
                    <div class="text-center p-2 mr-2" style="width: 48px">
                        <?php if (!empty($saison_precedente)): ?>
                            <a class="text-light" href="<?= route('aventure&saison=' . $saison_precedente->numero); ?>">
                                <?php echo file_get_contents(url_img('icons/chevron-left-solid.svg')); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- SAISON EN COURS -->
                    <div>SAISON <?= $saison_trouve->numero ?></div>

                    <!-- BOUTON SAISON SUIVANTE -->
                    <div class="text-center p-2 ml-2" style="width: 48px">
                        <?php if (!empty($saison_suivante)): ?>
                            <a class="text-light" href="index.php?page=aventure&saison=<?= $saison_suivante->numero; ?>">
                                <?php echo file_get_contents(url_img('icons/chevron-right-solid.svg')); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </h1>
            <hr class="w-50">
            <p class="lead grand"><?= titre_stylise($saison_trouve->titre); ?></p>
        </div>

    </div>
</header>
<!-- HEADER SAISON -->
<header id="header-s<?= $saison_trouve->numero; ?>" class="header-fond py-md-4 py-sm-2"
style="background-image: linear-gradient(rgb(40,0,0,0.5),rgb(40,0,0,0.5)),url('<?= url_img($saison_trouve->image); ?>');">
    <div class="container">

        <?php include DOSSIER_VIEWS . '/parts/alerte.php'; ?>

        <div class="header">
            <h1 class="display-5 text-center">
                <div class="d-flex w-100 justify-content-center">

                    <!-- BOUTON SAISON PRECEDENTE -->
                    <div class="text-center" style="width: 64px">
                        <?php if (!empty($saison_precedente)) : ?>
                            <a href="index.php?page=aventure&saison=<?= $saison_precedente->numero; ?>">
                                <button class="btn btn-primary btn-lg text-center btn-saison" type="button">
                                    <i class="fas fa-caret-left"></i>
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- SAISON EN COURS -->
                    <div>SAISON <?= $saison_trouve->numero ?></div>

                    <!-- BOUTON SAISON SUIVANTE -->
                    <div class="text-center" style="width: 64px">
                        <?php if (!empty($saison_suivante)) : ?>
                            <a href="index.php?page=aventure&saison=<?= $saison_suivante->numero; ?>">
                                <button class="btn btn-primary btn-lg text-center btn-saison" type="button">
                                   <i class="fas fa-caret-right"></i>
                                </button>
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
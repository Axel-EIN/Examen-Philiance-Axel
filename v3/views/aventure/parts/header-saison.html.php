<!-- HEADER SAISON -->
<header id="header-s<?= $saison_trouve->numero; ?>" class="header-fond"
style="background-image: linear-gradient(rgb(40,0,0,0.5),rgb(40,0,0,0.5)),url('<?= url_img($saison_trouve->image); ?>');">
    <div class="container">
        <div class="header">
            <?php if(empty($_GET['chapitre'])): ?><div class="volatile"><?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?></div><?php endif; ?>
            <div class="text-center d-flex w-100 justify-content-center mt-3">

                <!-- BOUTON SAISON PRECEDENTE -->
                <div class="flex-grow-1 my-auto">
                    <div class="fleche text-center mr-2 ml-auto">
                        <?php if (!empty($saison_precedente)): ?>
                            <a class="text-light" href="<?= route('aventure&saison=' . $saison_precedente->numero); ?>">
                                <?php echo file_get_contents(url_img('icons/chevron-left-solid.svg')); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SAISON EN COURS -->
                <h2 class="pre-titre-saison mx-2">SAISON&nbsp;<?= $saison_trouve->numero ?></h2>

                <!-- BOUTON SAISON SUIVANTE -->
                <div class="flex-grow-1 my-auto">
                    <div class="fleche text-center mr-auto">
                        <?php if (!empty($saison_suivante)): ?>
                            <a class="text-light" href="index.php?page=aventure&saison=<?= $saison_suivante->numero; ?>">
                                <?php echo file_get_contents(url_img('icons/chevron-right-solid.svg')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr class="w-50">     
            <h1 class="lead-stylise grand ombre-txt"><?= titre_stylise($saison_trouve->titre); ?></h1>

                <!-- ADMIN : MODIFIER / SUPPRIMER -->
                <?php if(admin_connecte()): ?>
                <div class="header-btn">
                    <a class="text-light" href="<?= route('admin-modifier-saison&id=' . $saison_trouve->id); ?>" >
                        <i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                    <a href="<?= route('admin-supprimer-saison-handler&id=' . $saison_trouve->id); ?>" class="text-light"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer la saison : <?= $saison_trouve->titre ?> ?')">
                        <i class="fas fa-trash-alt"></i></a>
                </div>
                <?php endif; ?>
            
        </div>
    </div>
</header>
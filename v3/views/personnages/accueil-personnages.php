<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/personnages/parts/header-personnages.html.php'; ?>

<main class="container-fluid">
    <div class="container">
        <h2>Personnages Joueurs (PJs) :</h2>
        <section class="row">
        <?php foreach($pjs as $un_pj): ?>
            <article class="col-xl-2 col-lg-3 col-md-4 col-sm-6 py-3 ">
                <div class="card bg-dark text-white">
                        <img src="<?= url_img(clan_trouve_par_id($un_pj->clan_id)->mon); ?>" alt="Mon du clan"
                             style="position: absolute; top: -12px; left: -12px; z-index: 1; width: 48px;" />
                        <div class="fond-mask-fonce">
                            <img class="card-img" src="<?= url_img($un_pj->illustration); ?>" alt="Illustration du personnage">
                        </div>
                        <div class="card-img-overlay">
                            <h4 class="card-title"><?= $un_pj->nom; ?> <?= $un_pj->prenom; ?></h4>
                            <p class="card-text"><small><?= $un_pj->titres; ?></small></p>
                        </div>
                </div>
            </article>
        <?php endforeach; ?>
        </section>

        <h2>Personnages Non-Joueurs (PNJs) :</h2>
        <section class="row">
        <?php foreach($pnjs as $un_pnj): ?>
            <article class="col-xl-2 col-lg-3 col-md-4 col-sm-6 py-3 ">
                <div class="card bg-dark text-white">
                        <img src="<?= url_img(clan_trouve_par_id($un_pnj->clan_id)->mon); ?>" alt="Mon du clan"
                             style="position: absolute; top: -12px; left: -12px; z-index: 1; width: 48px;" />
                        <div class="fond-mask-fonce">
                            <img class="card-img" src="<?= url_img($un_pnj->illustration); ?>" alt="Illustration du personnage">
                        </div>
                        <div class="card-img-overlay">
                            <h4 class="card-title"><?= $un_pnj->nom; ?> <?= $un_pnj->prenom; ?></h4>
                            <p class="card-text"><small><?= $un_pnj->titres; ?></small></p>
                        </div>
                </div>
            </article>
        <?php endforeach; ?>
        </section>

    </div>>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
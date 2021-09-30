<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid">
    <section class="container">
        <h1><?= $personnage_trouve->nom; ?> <?= $personnage_trouve->prenom; ?></h1>

            <article class="row">
                <div class="col-6">
                    <img class="img-fluid" src="<?= url_img($personnage_trouve->illustration); ?>" />
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <h4 class="card-title"><?= $personnage_trouve->nom; ?> <?= $personnage_trouve->prenom; ?></h4>
                        <p class="card-text"><?= $personnage_trouve->titres; ?></p>
                        <p class="card-text"><?= $personnage_trouve->description; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Clan: <img style="width: 64px;" src="<?= url_img($personnage_clan->mon) ?>" alt="Image du Mon du Clan" /><strong style="color:<?= $personnage_clan->couleur ?>;"><?= $personnage_clan->nom; ?></strong></li>
                        <li class="list-group-item">Classe: <?= $personnage_classe->nom; ?></li>
                        <li class="list-group-item">Ecole: <?= $personnage_ecole->nom; ?></li>
                        <li class="list-group-item">Techniques: <?= $personnage_ecole->technique1_nom; ?><br/><small><?= $personnage_ecole->technique1_desc; ?></small></li>
                        <li class="list-group-item">Joueur: <?= $personnage_utilisateur->prenom; ?></li>
                    </ul>
                </div>
            </article>

    </section>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
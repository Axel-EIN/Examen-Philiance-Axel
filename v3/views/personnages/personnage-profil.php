<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid">
    <section class="container">
        <h1>Les Personnages</h1>

        <?php foreach($personnages as $un_personnage): ?>
            <article class="row">
                <div class="col-6">
                    <img class="img-fluid" src="<?= url_img($un_personnage->illustration); ?>" />
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <h4 class="card-title"><?= $un_personnage->nom; ?> <?= $un_personnage->prenom; ?></h4>
                        <p class="card-text"><?= $un_personnage->surnom; ?></p>
                        <p class="card-text"><?= $un_personnage->description; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Clan: <?= $un_personnage->clan_id; ?></li>
                        <li class="list-group-item">Classe: <?= $un_personnage->classe_id; ?></li>
                        <li class="list-group-item">Ecole: <?= $un_personnage->ecole_id; ?></li>
                        <li class="list-group-item">Joueur: <?= $un_personnage->utilisateur_id; ?></li>
                    </ul>
                </div>
            </article>
        <?php endforeach; ?>

    </section>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
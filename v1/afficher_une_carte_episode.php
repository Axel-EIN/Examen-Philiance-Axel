<div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
    <div class="card liste">
        <div class="fond-mask">
        <a href="episode.php?numero=<?= $numero_episode; ?>#tete-lecture">
            <img src="https://picsum.photos/1920/1080" alt="Chapitre <?= $numero_chapitre; ?> episode <?= $numero_episode; ?>" class="card-img-top img-fluid"/>
        </a>
        </div>
        <div class="card-body ancre-scene">
        <h5 class="card-title"><?= $numero_episode; ?> - <?= $titre_episode; ?></h5>
        <p class="card-text"><?= $resume_episode; ?></p>
        <a href="episode.php?numero=<?= $numero_episode; ?>#tete-lecture" class="btn-lire-ep btn btn-primary">Lire l'Episode</a>
        </div>
    </div>
</div>
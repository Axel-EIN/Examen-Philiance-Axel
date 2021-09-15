<!-- HEADER CHAPITRE -->
<section
    id="ch<?= $chapitre->numero; ?>-header"
    class="chapitre-fond fermer"
    style="background-color: #<?= $chapitre->couleur; ?>; background-image: linear-gradient(rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.3),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6)),url('<?= url_img($chapitre->image); ?>');">

    <div class="container pt-md-4 pt-sm-2">
        <div style="position: relative;">
            <div class="header" >
                <h1 class="display-5">CHAPITRE <?= $chapitre->numero; ?></h1>
                <hr class="my-md-2">
                <p id="tete-lecture-ch<?= $chapitre->numero; ?>" class="lead grand">
                    <?= titre_stylise($chapitre->titre); ?>
                </p>
                <p class="citation">
                    <?php echo nl2br($chapitre->citation); ?>
                </p>
            </div>

            <?php if(!empty($_GET['alerte']) && !empty($_GET['id']) && $_GET['id'] == $chapitre->numero): ?>
                <?php include DOSSIER_VIEWS . '/parts/alerte.php'; ?>
            <?php endif; ?>

            <?php if(empty($episodes)) $disabled='disabled';
                  else $disabled=''; ?>

                <!-- TOGGLE BUTTON : VOIR LES EPISODES | X -->
                <div class="container d-flex justify-content-start align-items-center p-0">

                <?php if (!empty($episodes)) : ?>
                    <a href="#tete-lecture-ch<?= $chapitre->numero; ?>">
                        <button class="btn btn-primary btn-lg text-center voir" type="button" data-toggle="collapse" data-target="#ch<?= $chapitre->numero; ?>-episodes" aria-controls="ch<?= $chapitre->numero; ?>-episodes" aria-expanded="true" aria-label="Toggle Chapitre <?= $chapitre->numero; ?> Episodes">Voir les Episodes</button>
                    </a>
                <?php else: ?>
                    <a class="btn btn-primary btn-lg text-center disabled pasdispo" type="button">Voir les Episodes</a>
                <?php endif; ?>
                
                </div>


            <!-- EPISODES DU CHAPITRE -->
            <div id="ch<?= $chapitre->numero; ?>-episodes" class="collapse">
                <div class="container">
                    <div class="row justify-content-center">
                    <?php if(!empty($episodes)): ?>
                    <?php foreach ($episodes as $episode): ?>

                    <!-- CARTE POUR CHAQUE EPISODE -->
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
                                <a href="<?= route('episode&id=' . $episode->id); ?>#tete-lecture" class="btn btn-primary"><i class="fab fa-readme"></i>&nbsp;&nbsp;Lire l'Episode</a>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="chapitre-separateur"></div>
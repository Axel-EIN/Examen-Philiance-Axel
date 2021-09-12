<!-- HEADER CHAPITRE -->
<section id="ch<?= $chapitre->numero; ?>-header" class="chapitre-fond fermer"
style="background-color: #<?= $chapitre->couleur; ?>;
background-image: linear-gradient(rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.3),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6)),url('<?= $chapitre->image; ?>');">
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
            <?php
                if(empty($episodes)) $disabled='disabled';
                else $disabled='';
            ?>
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
            <!-- LES EPISODES DU CHAPITRE -->
            <div id="ch<?= $chapitre->numero; ?>-episodes" class="collapse">
                <div class="container">
                    <div class="row justify-content-center">
                      <?php if(!empty($episodes)) {
                                foreach ($episodes as $episode) : ?>

                                    <!-- CARTE RESUME POUR CHAQUE EPISODE -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
                                        <div class="card liste">
                                            <div style="color: white; font-size:3rem; font-weight: bold;position: absolute; left: 16px; top: 54px; z-index: 100"><?= $episode->numero; ?></div>
                                            <div class="fond-mask">
                                                <a href="<?= route('episode&episode=' . $episode->numero . '&saison=' . $episode->id_saison); ?>#tete-lecture">
                                                    <img src="<?= $episode->image; ?>" alt="Chapitre <?= $chapitre->numero; ?> episode <?= $episode->numero; ?>" class="card-img-top img-fluid"/>
                                                </a>
                                            </div>
                                            <div class="card-body ancre-scene">
                                            <h5 class="card-title" style="font-size: 1rem;"><?= $episode->titre; ?></h5>
                                            <p class="card-text"><?= $episode->resume; ?></p>
                                            </div>
                                            <div class="text-center p-2">
                                                <a href="<?= route('episode&episode=' . $episode->numero . '&saison=' . $episode->id_saison); ?>#tete-lecture" class="btn btn-primary"><i class="fab fa-readme"></i>&nbsp;&nbsp;Lire l'Episode</a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach;
                            } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="chapitre-separateur"></div>
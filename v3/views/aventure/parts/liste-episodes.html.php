 <!-- LISTE DES EPISODES D'UN CHAPITRE -->
 <div id="ch<?= $chapitre->numero; ?>-episodes"
    class="collapse <?php if(!empty($_GET['chapitre']) && $_GET['chapitre'] == $chapitre->numero): ?>show<?php endif; ?>">
    <div class="container">
        <div class="row justify-content-center">
            <?php if(!empty($episodes)): ?>
                <!-- CARTE POUR CHAQUE EPISODE -->
                <?php foreach ($episodes as $episode): ?>   
                    <div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
                        <div class="card liste">
                            <div class="numero"><?= $episode->numero; ?></div>
                            <div class="fond-mask">
                                <a href="<?= route('episode&id=' . $episode->id); ?>#tete-lecture">
                                    <img src="<?= url_img($episode->image); ?>" alt="Image de <?= $episode->titre; ?>" class="card-img-top img-fluid survol" />
                                </a>
                            </div>
                            <div class="card-body ancre-scene">
                                <h5 class="card-title" style="font-size: 1rem;"><?= $episode->titre; ?></h5>
                                <p class="card-text"><?= $episode->resume; ?></p>
                            </div>
                            <div class="text-center p-2">
                                <a href="<?= route('episode&id=' . $episode->id); ?>#tete-lecture" class="btn btn-primary">
                                    <i class="fab fa-readme"></i>&nbsp;&nbsp;Lire l'épisode
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- BOUTON AJOUTER UN EPISODE -->
            <?php if(admin_connecte()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 order-8 newpad">
                    <a class="gros-bouton" href="<?= route('admin-creer-episode&id_chapitre=' . $chapitre->id); ?>">
                        <div class="card new">
                            <h4>Ajouter un épisode</h4>
                            <?php echo file_get_contents(url_img("icons/plus-square-solid.svg")); ?>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
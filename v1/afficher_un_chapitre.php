<!-- HEADER CHAPITRE -->
<?php

$r = 0;
$g = 0;
$b = 0;
couleur_hexa_plus_sombre_rgb($couleur_chapitre, $r, $g, $b, 30);

?>
<section id="ch<?= $numero_chapitre; ?>-header" class="chapitre-fond fermer" style="background-color: #<?= $couleur_chapitre; ?>;background-image: linear-gradient(rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.3),rgb(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.6)),url('<?= $image_chapitre; ?>');">
    <div class="container pt-md-4 pt-sm-2">
        <div style="position: relative;">
            <div class="header" >
                <h1 class="display-5">CHAPITRE <?= $numero_chapitre; ?></h1>
                <hr class="my-md-2">
                <p id="tete-lecture-ch<?= $numero_chapitre; ?>" class="lead grand">
                    <?= $entete_chapitre; ?>
                </p>
                <p class="citation">
                    <?php echo nl2br($citation_chapitre); ?>
                </p>
            </div>
            <?php
                if(empty($episodes)) $disable='disabled';
                else $disable='';
            ?>
                <!-- TOGGLE BUTTON : VOIR LES EPISODES | X -->
                <div class="container d-flex justify-content-start align-items-center p-0">
                    <a href="#tete-lecture-ch<?= $numero_chapitre; ?>">
                        <button class="btn btn-primary btn-lg text-center voir <?= $disable ?>" type="button" data-toggle="collapse" data-target="#ch<?= $numero_chapitre; ?>-episodes" aria-controls="ch<?= $numero_chapitre; ?>-episodes" aria-expanded="true" aria-label="Toggle Chapitre <?= $numero_chapitre; ?> Episodes">Voir les Episodes</button>
                    </a>
                </div>
            <!-- LES EPISODES DU CHAPITRE -->
            <div id="ch<?= $numero_chapitre; ?>-episodes" class="collapse">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php
                            if(!empty($episodes))
                                foreach ($episodes as $cle => $galeur) afficher_une_carte_episode($episodes[$cle]);
                            else { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Il n'y a pas encore d'Episodes disponible pour ce Chapitres!</strong>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="chapitre-separateur"></div>
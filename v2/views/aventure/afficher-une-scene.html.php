<!-- UNE SCENE -->
<article id="scn<?= $scene->numero; ?>" class="mb-3">

    <!-- IMAGE -->
    <div class="fond-mask">
        <img src="<?= url_img($scene->image); ?>" class="card-img-top img-fluid" alt="<?php echo $scene->titre; ?>">
    </div>

    <!-- CORPS DE LA SCENE -->
    <div class="card-body">

        
        <div class="ancre-scene">

            <!-- ALERTE -->
            <?php if (!empty($_GET['alerte']) && !empty($_GET['scene_id']) && $_GET['scene_id'] == $scene->id): ?>
                <div style="position: absolute; top: -64px;">
                    <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
                </div>
            <?php endif; ?>

            <!-- LEGENDE OVERLAY-->
            <div class="scene-heure">
                <h5 class="card-title"><?php echo $scene->temps; ?></h5>
                <h3 class="card-title"><?php echo $scene->titre; ?></h3>
            </div>

        </div>

        <!-- TEXTE -->
        <p class="card-text"><?php echo nl2br($scene->texte); ?></p>

    </div>

    <!-- ADMIN - MODIFIER | SUPRIMER -->
    <?php if(admin_connecte()): ?>
        <div class="d-flex justify-content-center">
            <div class="col-2 text-center">
                <a href="<?= route('admin-modifier-scene&id=' . $scene->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Modifier</a>
            </div>
            <div>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-2 text-center">
                <a  href="<?= route('admin-supprimer-scene-handler&id=' . $scene->id); ?>"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer la scène : <?= $scene->titre ?> ?')">
                        <i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Supprimer
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- SEPARATEUR -->
    <div class="d-flex justify-content-center">
        <div class="d-flex align-items-center division text-center">
            <div class="col py-0 px-2"><hr></div>
            <div class="division-motif"><img src="assets/img/ornament-1.png" class="img-fluid" alt="ornament" /></div>
            <div class="col py-0 px-2"><hr></div>
        </div>
    </div>

    <!-- ADMIN - INSERER A LA FIN -->
    <?php if(admin_connecte()): $numero = $scene->numero+1; ?>
        <?php include DOSSIER_VIEWS . '/boutons/inserer-scene.html.php'; ?>
    <?php endif; ?>
    
</article>
<!-- FIN : UNE SCENE -->
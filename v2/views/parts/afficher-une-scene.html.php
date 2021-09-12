<!-- UNE SCENE -->
<article id="scn<?= $scene->numero; ?>" class="mb-5">
    <!-- IMAGE -->
    <div class="fond-mask">
        <img src="<?php echo $scene->image; ?>" class="card-img-top img-fluid" alt="<?php echo $scene->titre; ?>">
    </div>

    <div class="card-body">

        <!-- LEGENDE en Sur-Impression sur l'image ci-dessus-->
        <div class="ancre-scene">
            <!-- ALERTE -->
            <?php if (!empty($_GET['alerte']) && !empty($_GET['scene_id']) && $_GET['scene_id'] == $scene->id): ?>
                <div style="position: absolute; top: -64px;">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Super!</strong> <?= $_GET['alerte']; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="scene-heure">
                <h5 class="card-title"><?php echo $scene->temps; ?></h5>
                <h3 class="card-title"><?php echo $scene->titre; ?></h3>
            </div>
        </div>  
        <!-- TEXTE -->
        <p class="card-text"><?php echo nl2br($scene->texte); ?></p>

    </div>

    <?php if(admin_connecte()): ?>
        <div class="d-flex justify-content-center">
            <div class="col-2 text-center">
                <a href="<?= route('admin-modifier-scene&id=' . $scene->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Modifier</a>
            </div>
            <div>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-2 text-center">
                <a href="<?= route('admin-supprimer-scene-handler&id=' . $scene->id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la scène : <?= $scene->titre ?> ?')"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Supprimer</a>
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
    
</article>
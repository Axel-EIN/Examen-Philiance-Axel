<!-- UNE SCENE -->
<article>
    <!-- IMAGE -->
    <div class="fond-mask">
        <img src="<?php echo $scene_image; ?>" class="card-img-top img-fluid" alt="<?php echo $scene_titre; ?>">
    </div>

    <div class="card-body">

        <!-- LEGENDE en Sur-Impression sur l'image ci-dessus-->
        <div class="ancre-scene">
            <div class="scene-heure">
                <h5 class="card-title"><?php echo $scene_temps; ?></h5>
                <h3 class="card-title"><?php echo $scene_titre; ?></h3>
            </div>
        </div>  
        <!-- TEXTE -->
        <p class="card-text"><?php echo nl2br($scene_texte); ?></p>

    </div>

    <!-- SEPARATEUR -->
    <div class="d-flex justify-content-center">
        <div class="d-flex align-items-center division mb-5 text-center">
            <div class="col py-0 px-2"><hr></div>
            <div class="division-motif"><img src="images/ornament-1.png" class="img-fluid" alt="ornament" /></div>
            <div class="col py-0 px-2"><hr></div>
        </div>
    </div>
</article>
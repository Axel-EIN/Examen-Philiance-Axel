<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container-fluid bg-light">
    <?php include DOSSIER_VIEWS . '/admin/parts/nav-admin.html.php'; ?>
        
    <header class="container p-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?= $h1; ?></h1>
                <?php include_once DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
            </div>
        </div>
    </header>

    <main class="container">

        <form class="col-8 offset-2 mb-5" method="post"
            action="<?= route('admin-creer-saison-handler'); ?>" enctype="multipart/form-data">

            <!-- TITRE -->
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre"><br/>

            <div class="form-row">
                <!-- SAISON -->
                <div class="col-6">
                    <label for="saison">Choisir la position de la Saison</label>
                    <select class="form-control" id="saison" name="numero" required>
                        <?php if($toutes_les_saisons): ?>
                            <?php foreach($toutes_les_saisons as $une_saison): ?>
                                <option value="<?= $une_saison->numero ?>">
                                    <?= $une_saison->numero; ?> - Insérer devant <?= $une_saison->titre ?>
                                </option>
                            <?php endforeach; ?>
                                <option value="<?= $une_saison->numero+1; ?>">
                                    <?= $une_saison->numero+1; ?> - Insérer en dernier
                                </option>
                        <?php else: ?>
                            <option value="1" selected>1 - Insérer en premier</option>
                        <?php endif; ?>
                    </select>
                </div>
                <!-- COULEUR -->
                <div class="col-6">
                    <label for="couleur">Couleur de fond</label>
                    <input type="color" class="form-control" name="couleur" id="couleur">
                </div>
            </div>
            <br/>

            <!-- IMAGE -->
            <label for="image">Image (facultative)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image" aria-describedby="fileHelpId" id="image">
                <label class="custom-file-label" for="image">Chargez une image...</label>
                <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1920x1080 minimum, rapport 16/9</small>
            </div><br/><br/>
            
            <input class="form-control btn btn-primary" type="submit" value="Créer" name="creer" />
        </form>

    </main>
</div>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/b4_customfile_change.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
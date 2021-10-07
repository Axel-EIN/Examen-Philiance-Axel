<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container-fluid bg-light">
    <?php include DOSSIER_VIEWS . '/admin/parts/nav-admin.html.php'; ?>

    <header class="container p-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?= $h1; ?></h1>
            </div>
            <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
        </div>
    </header>

    <main class="container">

        <form class="col-8 offset-2 mb-5"
            method="post" action="<?= route('admin-modifier-saison-handler&id=' . $_GET['id']); ?>" enctype="multipart/form-data">

            <!-- TITRE -->
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre" value="<?= $saison_trouve->titre; ?>"><br/>

            <div class="form-row">
                <!-- SAISON -->
                <div class="col-6">
                    <label for="saison">Choisir la position du saison</label>
                    <select class="form-control" id="saison" name="numero" required>
                        <option value="" disabled>Choisir la position de la Saison...</option>

                        <?php foreach($toutes_les_saisons as $une_saison): ?>
                            <option value="<?= $une_saison->numero; ?>" <?php if($une_saison->id == $saison_trouve->id) echo "selected" ?>>
                                <?= $une_saison->numero; ?> - <?php if ($une_saison->id == $saison_trouve->id): ?>position actuel
                                <?php else : ?>à la place de : <?= $une_saison->titre; endif; ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <!-- COULEUR -->
                <div class="col-6">
                    <label for="couleur">Couleur de fond</label>
                    <input type="color" class="form-control" name="couleur" id="couleur" value="<?= $saison_trouve->couleur; ?>"><br/>
                </div>
            </div>

            <!-- APERÇUS IMAGE -->
            <label for="image">Image</label>
            <img class="img-fluid" src="<?= url_img($saison_trouve->image); ?>" alt="Image de la Saison <?= $saison_trouve->numero; ?>" />

            <!-- IMAGE -->
            <div class="custom-file mt-3">
                <input type="file" class="custom-file-input" name="image" aria-describedby="fileHelpId" id="image">
                <label class="custom-file-label" for="image">Chargez une image...</label>
                <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1920x1080 minimum, rapport 16/9</small>
            </div><br/><br/>
            
            <input class="form-control btn btn-primary" type="submit" value="Modifier" name="modifier" />
        </form>

    </main>
</div>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/b4_customfile_change.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
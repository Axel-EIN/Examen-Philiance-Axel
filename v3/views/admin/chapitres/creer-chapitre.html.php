<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container-fluid bg-light">
    <?php include DOSSIER_VIEWS . '/admin/parts/nav-admin.html.php'; ?>

    <header class="container p-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?= $h1; ?></h1>

                <?php include_once DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>

                <!-- TITRE SI ID SAISON PARENT FOURNI -->
                <?php if(!empty($saison_parent)): ?> 
                    <h4 class="text-center">
                        <small>pour </small>
                        <a href="<?= route('aventure&saison=' . $saison_parent->numero); ?>">
                            <?= $saison_parent->titre ?>&nbsp;<i class="fas fa-eye"></i>
                        </a>
                    </h4>
                <?php endif; ?>

            </div>
        </div>
    </header>

    <main class="container">

        <form class="col-8 offset-2 mb-5" method="post"
            action="<?= route('admin-creer-chapitre-handler' . $get_saison); ?>" enctype="multipart/form-data">

            <div class="form-row">
                <!-- TITRE -->
                <div class="col-6">
                    <label for="titre">Titre</label>
                    <input class="form-control" type="text" name="titre" id="titre">
                </div>
                <!-- COULEUR -->
                <div class="col-6">
                    <label for="couleur">Couleur de fond</label>
                    <input type="color" class="form-control" name="couleur" id="couleur">
                </div>
            </div>
            
            <br/>

            <div class="form-row">

                <!-- S'AFFICHE SEULEMENT SI LA SAISON EST NON FOURNI -->
                <?php if(empty($saison_parent)): ?>
                <div class="col-6">
                    <label for="saison">Choisir la saison à rattacher</label>
                    <select class="form-control" id="saison" name="id_saison" required onchange="chapitreChange(this);">
                        <option value="">Choisir une Saison...</option>

                        <?php foreach($toutes_les_saisons as $une_saison): ?>
                            <option value="<?= $une_saison->id; ?>"><?= $une_saison->titre; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <?php endif; ?>

                <!-- CHAPITRE -->
                <div class="col-6">
                    <label for="chapitre">Choisir la position du Chapitre</label>
                    <select class="form-control" id="chapitre" name="numero" required>
                        
                        <?php if(empty($saison_parent) || empty($_GET['numero'])): ?>
                            <option value="" disabled></option>
                        <?php else: ?>
                            <?php if($chapitres_enfants): ?>
                                <?php foreach($chapitres_enfants as $un_chapitre): ?>
                                    <option value="<?= $un_chapitre->numero ?>"
                                        <?php if($un_chapitre->numero == $_GET['numero']) echo ' selected'; ?>>
                                            <?= $un_chapitre->numero; ?> - Insérer devant <?= $un_chapitre->titre ?>
                                    </option>
                                <?php endforeach; ?>
                                    <option value="<?= $un_chapitre->numero+1; ?>"
                                        <?php if($un_chapitre->numero+1 == $_GET['numero']) echo ' selected'; ?>>
                                            <?= $un_chapitre->numero+1; ?> - Insérer en dernier
                                    </option>
                            <?php else: ?>
                                <option value="1" selected>1 - Insérer en premier</option>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- MJ -->
                <div class="col-6">
                    <label for="mj">Maître du Jeu</label>
                    <select class="form-control" name="id_mj" id="mj">
                        <?php foreach($utilisateurs as $un_utilisateur): ?>
                            <option value="<?= $un_utilisateur->id; ?>">
                                <?= $un_utilisateur->prenom; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

            <!-- CITATION -->
            <label for="citation">Citation</label>
            <textarea style="resize: none;" class="form-control" maxlength="200" name="citation" id="citation" cols="30" rows="3"></textarea><br/>
            
            <input class="form-control btn btn-primary" type="submit" value="Créer" name="creer" />
        </form>

    </main>
</div>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/b4_customfile_change.js.php'; ?>

<script type="text/javascript">
    // CONSTRUCTION des tableaux avec les données BDD qui seront utilisé pour les liste déroulantes

    var saisonsArray = new Array(<?= count($toutes_les_saisons); ?>);

    <?php foreach ($toutes_les_saisons as $une_saison): ?>
        saisonsArray["<?= $une_saison->id ?>"] = {"" : "Choisir la position du Chapitre...",
            <?php if (!empty(chapitres_enfants_de_saison_tries_numero($une_saison->id))): ?>
                <?php foreach (chapitres_enfants_de_saison_tries_numero($une_saison->id) as $un_chapitre): ?>  
                    "<?= $un_chapitre->numero; ?>" : "<?= $un_chapitre->numero ?> - Insérer devant : <?= $un_chapitre->titre; ?>",
                <?php endforeach; ?>
                    "<?= $un_chapitre->numero+1; ?>" : "<?= $un_chapitre->numero+1 ?> - Insérer en dernier",
            <?php else: ?>
                "1" : "1 - Ajouter en premier chapitre",
            <?php endif; ?>
        };
    <?php endforeach; ?>

    function chapitreChange(selectObj) { // RECREE la liste déroulante pour choisir les chapitres
        
        var idx = selectObj.selectedIndex; // stock l'index DOM de l'objet cliqué
        var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index
        
        chapitresList = saisonsArray[which]; // Utilise cette valeur comme clé pour chercher dans le tableau les chapitres

        var chapitresSelect = document.getElementById("chapitre"); // stock l'element DOM <select> qui a l'id "chapitre"
        var len = chapitresSelect.options.length; // calcul la longueur des options à effacer 
        while (chapitresSelect.options.length > 0) // efface tant que ce n'est pas 0
            chapitresSelect.remove(0);

        var newOption; // création de nouvelles options
        for (var key in chapitresList) {
            newOption = document.createElement("option");
            newOption.value = key;  // la valeur de l'option sera le numero de la clé associative du tableau
            newOption.text = chapitresList[key]; // le texte de l'option sera la valeur de la clé associative du tableau
            if (newOption.value == '') {
                newOption.setAttribute('disabled', true);
                newOption.setAttribute('selected', true);
            }

            // On ajoute/rattache les <options> à l'élement DOM  <select>
            try { chapitresSelect.add(newOption); } // pour IE
            catch (e) { chapitresSelect.appendChild(newOption); }
        }
    }
</script>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
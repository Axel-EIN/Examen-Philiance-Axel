<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<header class="container p-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"><?= $h1; ?></h1>
        </div>

        <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>

    </div>
</header>

<main class="container">

    <form class="col-8 offset-2 mb-5"
        method="post" action="<?= route('admin-modifier-chapitre-handler&id=' . $_GET['id']); ?>" enctype="multipart/form-data">

        <label for="titre">Titre</label>
        <input class="form-control" type="text" name="titre" id="titre" value="<?= $chapitre_trouve->titre; ?>"><br/>

        <div class="form-row">
            <div class="col-6">
                <label for="saison">Choisir une saison</label>
                <select class="form-control" id="saison" name="id_saison" required onchange="chapitreChange(this);">
                    <option value="" disabled>Choisir une Saison...</option>
                    <?php foreach($toutes_les_saisons as $une_saison): ?>
                        <option value="<?= $une_saison->id; ?>" <?php if($une_saison->id == $saison_parent->id) echo "selected" ?>>
                            <?= $une_saison->titre; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6">
                <label for="id_chapitre">Choisir la position du chapitre</label>
                <select class="form-control" id="chapitre" name="numero" required>
                    <option value="" disabled>Choisir la position du Chapitre...</option>

                    <?php foreach(chapitres_enfants_de_saison_tries_numero($saison_parent->id) as $un_chapitre): ?>
                        <option value="<?= $un_chapitre->numero; ?>" <?php if($un_chapitre->id == $chapitre_trouve->id) echo "selected" ?>>
                            <?= $un_chapitre->numero; ?> - <?php if ($un_chapitre->id == $chapitre_trouve->id): ?>position actuel
                            <?php else : ?>à la place de : <?= $un_chapitre->titre; endif; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div><br/>

        <div class="form-row">
            <div class="col-6">
                <label for="mj">Maître du Jeu</label>
                <select class="form-control" name="id_mj" id="mj">
                    <?php foreach($utilisateurs as $un_utilisateur): ?>
                        <option value="<?= $un_utilisateur->id; ?>" <?php if($un_utilisateur->id == $chapitre_trouve->id_mj): ?>selected<?php endif; ?>>
                            <?= $un_utilisateur->prenom; ?><?php if($un_utilisateur->id == $chapitre_trouve->id_mj): ?> (MJ actuel)<?php endif; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6">
                <label for="couleur">Couleur de fond</label>
                <input type="color" class="form-control" name="couleur" id="couleur" value="<?= $chapitre_trouve->couleur; ?>"><br/>
            </div>
        </div>

        <label for="image">Image</label>
        <img class="img-fluid" src="<?= url_img($chapitre_trouve->image); ?>" alt="Image du chapitre <?= $chapitre_trouve->numero; ?>" />

        <div class="custom-file mt-3">
            <input type="file" class="custom-file-input" name="image" aria-describedby="fileHelpId" id="image">
            <label class="custom-file-label" for="image">Chargez une image...</label>
            <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1920x1080 minimum, rapport 16/9</small>
        </div><br/><br/>

        <label for="citation">Citation</label>
        <textarea style="resize: none;" class="form-control" maxlength="200" name="citation" id="citation" cols="30" rows="3">
            <?= $chapitre_trouve->citation; ?>
        </textarea><br/>
        
        <input class="form-control btn btn-primary" type="submit" value="Modifier" name="modifier" />
    </form>

</main>

<script type="text/javascript">

// CONSTRUCTION des tableaux avec les données BDD qui seront utilisé pour les liste déroulantes

var saisonsArray = new Array(<?= count($toutes_les_saisons); ?>);

<?php foreach ($toutes_les_saisons as $une_saison): ?>
    saisonsArray["<?= $une_saison->id ?>"] = {"" : "Choisir la position du Chapitre...",
        <?php if (empty(chapitres_enfants_de_saison_tries_numero($une_saison->id))): ?>
            "1" : "1 - Déplacer ici en premier chapitre",
        <?php else: ?>
            <?php $trouvee = false; ?>
            <?php foreach (chapitres_enfants_de_saison_tries_numero($une_saison->id) as $un_chapitre): ?>
                "<?= $un_chapitre->numero; ?>" : "<?= $un_chapitre->numero; ?> - <?php if ($un_chapitre->id == $chapitre_trouve->id): $trouvee = true; ?>
                position actuel<?php else: ?>à la place de : <?= $un_chapitre->titre; endif; ?>",
            <?php endforeach; ?>
            <?php if ($trouvee == false): ?>
                "<?= $un_chapitre->numero+1; ?>" : "<?= $un_chapitre->numero+1; ?> - Insérer en dernier",
            <?php endif; ?>
        <?php endif; ?>
    };
<?php endforeach; ?>

function chapitreChange(selectObj) { 
     
    var idx = selectObj.selectedIndex; // stock l'index (position de l'élément de la liste) de l'objet cliqué
    
    var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index
    
    chapitresList = saisonsArray[which]; // Utilise cette valeur comme clé pour récupérer la liste des chapitres et la stock

    var chapitresSelect = document.getElementById("chapitre"); // stock l'element DOM <select> qui a l'id "chapitre"
    var len = chapitresSelect.options.length; // calcul la longueur des options à effacer 
    while (chapitresSelect.options.length > 0) // efface tant que ce n'est pas 0
        chapitresSelect.remove(0);

    var newOption; // création de nouvelles options
    for (var key in chapitresList) {
        newOption = document.createElement("option");
        newOption.value = key;  // créé la valeur de l'option 
        newOption.text = chapitresList[key]; // créé le texte de l'option
        if (newOption.value == '')
            newOption.setAttribute('disabled', true);

        if (newOption.value == <?= $chapitre_trouve->id; ?>)
            newOption.setAttribute('selected', true); // On met l'attribut selected
        else if (newOption.value == '')
            newOption.setAttribute('selected', true); // On met l'attribut selected

        // On ajoute/rattache les <options> à l'élement DOM 
        try { chapitresSelect.add(newOption); } // pour IE
        catch (e) { chapitresSelect.appendChild(newOption); }
    }
}
</script>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
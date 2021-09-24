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

    <form class="col-8 offset-2 mb-5" method="post" action="<?= route('admin-modifier-scene-handler&id=' . $_GET['id']); ?>" enctype="multipart/form-data">

        <label for="titre">Titre</label>
        <input class="form-control" type="text" name="titre" id="titre" value="<?= $scene_trouve->titre; ?>"><br/>

        <div class="form-row">
            <div class="col-6">
                <label for="saison">Choisir une saison</label>
                <select class="form-control" id="saison" required onchange="chapitreChange(this);">
                    <option value="" disabled>Choisir une Saison...</option>

                    <?php foreach($toutes_les_saisons as $une_saison): ?>
                        <option value="<?= $une_saison->id; ?>" <?php if($une_saison->id == $saison_parent->id) echo "selected" ?>><?= $une_saison->titre; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
            <div class="col-6">
                <label for="chapitre">Choisir un chapitre</label>
                <select class="form-control" id="chapitre" required onchange="episodeChange(this);">
                    <option value="" disabled>Choisir un Chapitre...</option>

                    <?php foreach(chapitres_enfants_de_saison($saison_parent->id) as $un_chapitre): ?>
                        <option value="<?= $un_chapitre->id; ?>" <?php if($un_chapitre->id == $chapitre_parent->id) echo "selected" ?>><?= $un_chapitre->titre; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div><br/>
        <div class="form-row">
            <div class="col-6">
                <label for="episode">Choisir un épisode</label>
                <select class="form-control" id="episode" name="id_episode" required onchange="sceneChange(this);">
                    <option value="" disabled>Choisir un Episode...</option>

                    <?php foreach(episodes_enfants_du_chapitre($chapitre_parent->id) as $un_episode): ?>
                        <option value="<?= $un_episode->id; ?>" <?php if($un_episode->id == $episode_parent->id) echo "selected" ?>><?= $un_episode->titre; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
            <div class="col-6">
                <label for="scene">Choisir la Position de la scène</label>
                <select class="form-control" id="scene" name="numero" required>
                    <option value="" disabled>Choisir la position de la scène...</option>

                    <?php foreach(scenes_enfants_de_episode_triees_numero($episode_parent->id) as $une_scene): ?>
                        <option value="<?= $une_scene->numero; ?>" <?php if($une_scene->id == $scene_trouve->id) echo "selected" ?>><?= $une_scene->numero; ?> - <?php if ($une_scene->id == $scene_trouve->id): ?>position actuel<?php else: ?>à la place de : <?= $une_scene->titre; endif;?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div><br/>

        <label for="image">Image</label>
        <img class="img-fluid" src="<?= url_img($scene_trouve->image); ?>" alt="Image de la scène <?= $scene_trouve->numero; ?>" />
        <div class="form-group">
          <label for="image"></label>
          <input type="file" class="form-control-file" name="image" id="image" aria-describedby="fileHelpId">
          <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1280x720 minimum, rapport 16/9</small>
        </div><br/>

        <label for="temps">Temps dans le jeu</label>
        <input class="form-control" type="text" name="temps" id="temps" value="<?= $scene_trouve->temps; ?>"><br/>

        <label for="texte">Texte</label>
        <textarea style="resize: none;" class="form-control" name="texte" id="texte" cols="30" rows="11"><?= $scene_trouve->texte; ?></textarea><br/>
        
        <input class="form-control btn btn-primary" type="submit" value="Modifier" name="modifier" />
    </form>

</main>

<script type="text/javascript">
// CONSTRUCTION des tableaux avec les données BDD qui seront utilisé pour les liste déroulantes

var saisonsArray = new Array(<?= count($toutes_les_saisons); ?>);

<?php foreach ($toutes_les_saisons as $une_saison): ?>
    saisonsArray["<?= $une_saison->id ?>"] = {"" : "Choisir un Chapitre...",
        <?php foreach (chapitres_enfants_de_saison($une_saison->id) as $un_chapitre): ?>
            "<?= $un_chapitre->id; ?>" : "<?= $un_chapitre->titre; ?>",
        <?php endforeach; ?> };
<?php endforeach; ?>

var episodesArray = new Array(<?= count($tous_les_chapitres); ?>);

<?php foreach ($tous_les_chapitres as $un_chapitre): ?>
    episodesArray["<?= $un_chapitre->id ?>"] = {"" : "Choisir un Episode...",
        <?php foreach (episodes_enfants_du_chapitre($un_chapitre->id) as $un_episode): ?>
            "<?= $un_episode->id; ?>" : "<?= $un_episode->titre; ?>",
        <?php endforeach; ?> };
<?php endforeach; ?>

var scenesArray = new Array(<?= count($tous_les_episodes); ?>);

<?php foreach ($tous_les_episodes as $un_episode): ?>
    scenesArray["<?= $un_episode->id ?>"] = {"" : "Choisir la position de la scène...",
        <?php if (empty(scenes_enfants_de_episode_triees_numero($un_episode->id))): ?>
            "1" : "1 - Déplacer ici en première scène",
        <?php else: ?>
            <?php $trouvee = false; ?>
            <?php foreach (scenes_enfants_de_episode_triees_numero($un_episode->id) as $une_scene): ?>  
                "<?= $une_scene->numero; ?>" : "<?= $une_scene->numero ?> - <?php if ($une_scene->id == $scene_trouve->id): $trouvee = true; ?>position actuel<?php else: ?>à la place de : <?= $une_scene->titre; endif; ?>",
            <?php endforeach; ?>
            <?php if ($trouvee == false): ?>
                "<?= $une_scene->numero+1; ?>" : "<?= $une_scene->numero+1; ?> - Insérer en dernier",
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

    var episodesSelect = document.getElementById("episode");  // stock l'element DOMD <select> qui a l'id "episode"
    var len = episodesSelect.options.length; // calcul la longueur des options à effacer
    while (episodesSelect.options.length > 0)
        episodesSelect.remove(0);

    var scenesSelect = document.getElementById("scene"); // stock l'element DOMD <select> qui a l'id "scene"
    var len = scenesSelect.options.length; // calcul la longueur des options à effacer
    while (scenesSelect.options.length > 0)
        scenesSelect.remove(0);

    var newOption; // création de nouvelles options
    for (var key in chapitresList) {
        newOption = document.createElement("option");
        newOption.value = key;  // créé la valeur de l'option 
        newOption.text = chapitresList[key]; // créé le texte de l'option
        if (newOption.value == '')
            newOption.setAttribute('disabled', true);

        if (newOption.value == <?= $chapitre_parent->id; ?>)
            newOption.setAttribute('selected', true); // On met l'attribut selected
        else if (newOption.value == '')
            newOption.setAttribute('selected', true); // On met l'attribut selected

        // On ajoute/rattache les <options> à l'élement DOM 
        try { chapitresSelect.add(newOption); } // pour IE
        catch (e) { chapitresSelect.appendChild(newOption); }
    }
}

function episodeChange(selectObj) { 
    
    var idx = selectObj.selectedIndex; // stock l'index (position de l'élément de la liste) de l'objet cliqué
    
    var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index

    episodesList = episodesArray[which]; // Utilise cette valeur comme clé pour récupérer la liste des chapitres et la stock

    var episodesSelect = document.getElementById("episode");  // stock l'element DOMD <select> qui a l'id "episode"
    var len = episodesSelect.options.length; // calcul la longueur des options à effacer
    while (episodesSelect.options.length > 0)
        episodesSelect.remove(0);

    var scenesSelect = document.getElementById("scene"); // stock l'element DOMD <select> qui a l'id "scene"
    var len = scenesSelect.options.length; // calcul la longueur des options à effacer
    while (scenesSelect.options.length > 0)
    scenesSelect.remove(0);

    var newOption; // création de nouvelles options
    for (var key in episodesList) { 
        newOption = document.createElement("option"); 
        newOption.value = key;  // créé la valeur de l'option 
        newOption.text = episodesList[key]; // créé le texte de l'option

        if (newOption.value == '')
            newOption.setAttribute('disabled', true);

        if (newOption.value == <?= $episode_parent->id; ?>)
            newOption.setAttribute('selected', true); // On met l'attribut selected
        else if (newOption.value == '')
            newOption.setAttribute('selected', true); // On met l'attribut selected

        // On ajoute/rattache les <options> à l'élement DOM  
        try { episodesSelect.add(newOption); } // pour IE  
        catch (e) { episodesSelect.appendChild(newOption); } 
    }
}

function sceneChange(selectObj) { 
     
    var idx = selectObj.selectedIndex; // stock l'index (position de l'élément de la liste) de l'objet cliqué
    
    var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index

    scenesList = scenesArray[which]; // Utilise cette valeur comme clé pour récupérer la liste des chapitres et la stock
    
    var scenesSelect = document.getElementById("scene"); // stock l'element DOMD <select> qui a l'id "scene"
    var len = scenesSelect.options.length; // calcul la longueur des options à effacer
    while (scenesSelect.options.length > 0)
        scenesSelect.remove(0);

    var newOption; // création de nouvelles options
    for (var key in scenesList) { 
        newOption = document.createElement("option"); 
        newOption.value = key; // créé la valeur de l'option 
        newOption.text = scenesList[key]; // créé le texte de l'option

        if (newOption.value == '')
            newOption.setAttribute('disabled', true);

        if (newOption.value == <?= $scene_trouve->numero; ?>) // Si la value = numero scene actuel
            newOption.setAttribute('selected', true); // On met l'attribut selected
        else if (newOption.value == '')
            newOption.setAttribute('selected', true); // On met l'attribut selected 

        // On ajoute/rattache les <options> à l'élement DOM 
        try { scenesSelect.add(newOption); } // pour IE 
        catch (e) { scenesSelect.appendChild(newOption); } 
    }
}
</script>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
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

        <form class="col-8 offset-2 mb-5" method="post" action="<?= route('admin-modifier-episode-handler&id=' . $_GET['id']); ?>" enctype="multipart/form-data">

            <!-- TITRE -->
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre" value="<?= $episode_trouve->titre; ?>"><br/>

            <div class="form-row">
                <!-- SAISON -->
                <div class="col-6">
                    <label for="saison">Choisir une saison</label>
                    <select class="form-control" id="saison" required onchange="chapitreChange(this);">
                        <option value="" disabled>Choisir une Saison...</option>

                        <?php foreach($toutes_les_saisons as $une_saison): ?>
                            <option value="<?= $une_saison->id; ?>" <?php if($une_saison->id == $saison_parent->id) echo "selected" ?>><?= $une_saison->titre; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <!-- CHAPITRE -->
                <div class="col-6">
                    <label for="id_chapitre">Choisir un chapitre</label>
                    <select class="form-control" id="chapitre" name="id_chapitre" required onchange="episodeChange(this);">
                        <option value="" disabled>Choisir un Chapitre...</option>

                        <?php foreach(chapitres_enfants_de_saison($saison_parent->id) as $un_chapitre): ?>
                            <option value="<?= $un_chapitre->id; ?>" <?php if($un_chapitre->id == $chapitre_parent->id) echo "selected" ?>><?= $un_chapitre->titre; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div><br/>
            <!-- EPISODE -->
            <div class="form-row">
                <div class="col-12">
                    <label for="numero">Choisir la position de l'épisode</label>
                    <select class="form-control" id="episode" name="numero" required >
                        <option value="" disabled>Choisir la position de l'épisode...</option>

                        <?php foreach(episodes_enfants_du_chapitre_triees_numero($chapitre_parent->id) as $un_episode): ?>
                            <option value="<?= $un_episode->numero; ?>" <?php if($un_episode->id == $episode_trouve->id) echo "selected" ?>><?= $un_episode->numero; ?> - <?php if ($un_episode->id == $episode_trouve->id): ?>position actuel<?php else: ?>à la place de : <?= $un_episode->titre; endif;?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div><br/>

            <!-- APERÇUS IMAGE -->
            <label for="image">Image</label>
            <img class="img-fluid" src="<?= url_img($episode_trouve->image); ?>" alt="Image de l'épisode <?= $episode_trouve->numero; ?>" />

            <!-- IMAGE -->
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="fileHelpId">
                <label class="custom-file-label" for="image">Chargez une image...</label>
                <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1280x720 minimum, rapport 16/9</small>
            </div><br/>

            <!-- RESUME -->
            <label for="resume">Bref résumé / Synopsis (2 lignes)</label>
            <textarea style="resize: none;" class="form-control" maxlength="200" name="resume" id="resume" cols="30" rows="2"><?= $episode_trouve->resume; ?></textarea><br/>
            
            <input class="form-control btn btn-primary" type="submit" value="Modifier" name="modifier" />
        </form>

    </main>
</div>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/b4_customfile_change.js.php'; ?>
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
        episodesArray["<?= $un_chapitre->id ?>"] = {"" : "Choisir la position de l'Episode...",
            <?php if (empty(episodes_enfants_du_chapitre_triees_numero($un_chapitre->id))): ?>
                "1" : "1 - Déplacer ici en premier episode",
            <?php else: ?>
                <?php $trouvee = false; ?>
                <?php foreach (episodes_enfants_du_chapitre_triees_numero($un_chapitre->id) as $un_episode): ?>
                    "<?= $un_episode->numero; ?>" : "<?= $un_episode->numero; ?> - <?php if ($un_episode->id == $episode_trouve->id): $trouvee = true; ?>
                    position actuel<?php else: ?>à la place de : <?= $un_episode->titre; endif; ?>",
                <?php endforeach; ?>
                <?php if ($trouvee == false): ?>
                    "<?= $un_episode->numero+1; ?>" : "<?= $un_episode->numero+1; ?> - Insérer en dernier",
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

        var newOption; // création de nouvelles options
        for (var key in episodesList) { 
            newOption = document.createElement("option"); 
            newOption.value = key;  // créé la valeur de l'option 
            newOption.text = episodesList[key]; // créé le texte de l'option
            if (newOption.value == '')
                newOption.setAttribute('disabled', true);

            if (newOption.value == <?= $episode_trouve->id; ?>)
                newOption.setAttribute('selected', true); // On met l'attribut selected
            else if (newOption.value == '')
                newOption.setAttribute('selected', true); // On met l'attribut selected

            // On ajoute/rattache les <options> à l'élement DOM  
            try { episodesSelect.add(newOption); } // pour IE  
            catch (e) { episodesSelect.appendChild(newOption); } 
        }
    }
</script>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
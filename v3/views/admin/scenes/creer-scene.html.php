<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container-fluid bg-light">
    <?php include DOSSIER_VIEWS . '/admin/parts/nav-admin.html.php'; ?>

    <!-- H1 -->
    <header class="container my-4">
        <h1 class="text-center"><?= $h1; ?></h1>

        <!-- LIEN SI ARRIVEE DEPUIS PAGE EPISODE = GET ID EPISODE PARENT FOURNI -->
        <?php if(!empty($episode_parent)): ?> 
            <h4 class="text-center"><small>pour </small>
                <a href="<?= route('episode&id=' . $episode_parent->id, "#tete-lecture"); ?>">
                <?= $episode_parent->titre ?>&nbsp;<i class="fas fa-eye"></i></a>
            </h4>
        <?php endif; ?>

    </header>

    <main class="container">
        <form id="form1" class="col-8 offset-2 mb-5" method="post" action="<?= route('admin-creer-scene-handler' . $get_episode); ?>" enctype="multipart/form-data">

            <!-- TITRE -->
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre" required autofocus placeholder="Entrez le titre de la Scène..."><br/>

            <!-- SI SAISON PARENT ET CHAPITRE PARENT VIDE -->
            <?php if (empty($saison_parent) && empty($chapitre_parent)): ?>
                <div class="form-row">
            <?php endif; ?>

                <!-- SAISON PARENT -->
                <?php if(empty($saison_parent)): ?>
                    <div class="col">
                        <label for="saison">Saison à rattacher</label>
                        <select class="form-control" id="saison" required onchange="chapitreChange(this);">

                            <option value="">Choisir une Saison...</option>

                            <?php foreach($toutes_les_saisons as $une_saison): ?>
                                <option value="<?= $une_saison->id; ?>"><?= $une_saison->titre; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                <?php endif; ?>

                <!-- CHAPITRE PARENT -->
                <?php if(empty($chapitre_parent)): ?>
                    <div class="col">
                        <label for="chapitre">Chapitre à rattacher</label>
                        <select class="form-control" id="chapitre" required onchange="episodeChange(this);">
                            <option value="" disabled></option>
                        </select>
                    </div>
                <?php endif; ?>

            <?php if (empty($saison_parent) && empty($chapitre_parent)): ?>
                </div><br/>
            <?php endif; ?>


            <div class="form-row">

                <!-- EPISODE PARENT -->
                <?php if(empty($episode_parent)): ?>
                    <div class="col">
                        <label for="episode">Épisode à rattacher</label>
                        <select class="form-control" id="episode" name="id_episode" required onchange="sceneChange(this);">
                            <option value="" disabled></option>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- POSITION SCENE -->
                <div class="col">
                    <label for="scene">Position de la scène</label>
                    <select class="form-control" id="scene" name="numero" required>
                        <?php if(empty($episode_parent) || empty($_GET['numero'])): ?>
                            <option value="" disabled></option>
                        <?php else: ?>
                            <?php if($scenes_enfants): ?>
                                <?php foreach($scenes_enfants as $une_scene): ?>
                                    <option value="<?= $une_scene->numero ?>"
                                        <?php if($une_scene->numero == $_GET['numero']) echo ' selected' ?>>
                                            <?= $une_scene->numero; ?> - Insérer devant <?= $une_scene->titre ?>
                                    </option>
                                <?php endforeach; ?>
                                    <option value="<?= $une_scene->numero+1; ?>"
                                        <?php if($une_scene->numero+1 == $_GET['numero']) echo 'selected'; ?>>
                                            <?= $une_scene->numero+1; ?> - Insérer en dernier
                                    </option>
                            <?php else: ?>
                                <option value="1">1 - Insérer en premier</option>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </div>

            </div><br/>

            <!-- TEMPS DU JEU -->
            <label for="temps">Temps dans le jeu</label>
            <input class="form-control" type="text" name="temps" id="temps" required placeholder="Précisez le moment de la journée ou la nuit dans le jeu"><br/>

            <!-- TEXTE -->
            <label for="texte">Texte</label>
            <textarea style="resize: none;" class="form-control" name="texte" id="texte" cols="30" rows="7" required></textarea><br/>

            <!-- IMAGE -->
            <label for="image">Image (facultative)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image" aria-describedby="fileHelpId" id="image">
                <label class="custom-file-label" for="image">Charger une image...</label>
                <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 1280x720 minimum, rapport 16/9</small>
            </div><br/><br/>

            Participants (facultatif) :<br/>
            <div class="form-row">

                <!-- PARTICIPATION PJs -->
                <div class="col-6 text-center">
                    <div class="text-right"><small class="mr-3">XP gagné / mort</small></div>
                    <button class="btn mt-2" style="background: #e9ecef;" id="add-participants">Ajouter un PJ</button>
                </div>

                <!-- PARTICIPATION PNJs -->
                <div class="col-6 text-center">
                    <div class="text-right"><small class="mr-4">Mort</small></div>
                    <button class="btn mt-2" style="background: #e9ecef;" id="add-participants_pnjs">Ajouter un PNJ</button>
                </div>

            </div>
            
            <!-- BOUTON VALIDER -->
            <input class="form-control btn btn-primary mt-4" type="submit" value="Créer" name="creer" />

        </form>
    </main>
</div>

<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/ajout_participations.js.php'; ?>
<?php include_once DOSSIER_SCRIPTS . '/b4_customfile_change.js.php'; ?>
<script type="text/javascript">
// script pour la CONSTRUCTION des tableaux avec les données BDD qui seront utilisé pour les liste déroulantes

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
            <?php if (!empty(scenes_enfants_de_episode_triees_numero($un_episode->id))): ?>
                <?php foreach (scenes_enfants_de_episode_triees_numero($un_episode->id) as $une_scene): ?>  
                    "<?= $une_scene->numero; ?>" : "<?= $une_scene->numero ?> - Insérer devant : <?= $une_scene->titre; ?>",
                <?php endforeach; ?>
                    "<?= $une_scene->numero+1; ?>" : "<?= $une_scene->numero+1 ?> - Insérer en dernier",
            <?php else: ?>
                "1" : "1 - Ajouter en première scène",
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

        var episodesSelect = document.getElementById("episode");  // stock l'element DOM <select> qui a l'id "episode"
        var len = episodesSelect.options.length; // calcul la longueur des options à effacer
        while (episodesSelect.options.length > 0) // efface tant que ce n'est pas 0
            episodesSelect.remove(0);

        var scenesSelect = document.getElementById("scene"); // stock l'element DOM <select> qui a l'id "scene"
        var len = scenesSelect.options.length; // calcul la longueur des options à effacer
        while (scenesSelect.options.length > 0) // efface tant que ce n'est pas 0
            scenesSelect.remove(0);

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

    function episodeChange(selectObj) { // RECREE la liste déroulante pour choisir les episodes
        
        var idx = selectObj.selectedIndex; // stock l'index DOM de l'objet cliqué
        var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index
        episodesList = episodesArray[which]; // Utilise cette valeur comme clé pour chercher dans le tableau les episodes

        var episodesSelect = document.getElementById("episode");  // stock l'element DOMD <select> qui a l'id "episode"
        var len = episodesSelect.options.length; // calcul la longueur des options à effacer
        while (episodesSelect.options.length > 0) // efface tant que ce n'est pas 0
            episodesSelect.remove(0);

        var scenesSelect = document.getElementById("scene"); // stock l'element DOMD <select> qui a l'id "scene"
        var len = scenesSelect.options.length; // calcul la longueur des options à effacer
        while (scenesSelect.options.length > 0) // efface tant que ce n'est pas 0
            scenesSelect.remove(0);

        var newOption; // création de nouvelles options
        for (var key in episodesList) { 
            newOption = document.createElement("option"); 
            newOption.value = key; // la valeur de l'option sera le numero de la clé associative du tableau 
            newOption.text = episodesList[key]; // le texte de l'option sera la valeur de la clé associative du tableau

            if (newOption.value == '') {
                newOption.setAttribute('disabled', true);
                newOption.setAttribute('selected', true);
            }

            // On ajoute/rattache les <options> à l'élement DOM  
            try { episodesSelect.add(newOption); } // pour IE  
            catch (e) { episodesSelect.appendChild(newOption); } 
        }
    }

    function sceneChange(selectObj) { // RECREE la liste déroulante pour choisir les scenes
        
        var idx = selectObj.selectedIndex; // stock l'index DOM de l'objet cliqué
        var which = selectObj.options[idx].value; // stock la valeur du champ option ciblé via son index
        scenesList = scenesArray[which]; // Utilise cette valeur comme clé pour chercher dans le tableau les scenes
        
        var scenesSelect = document.getElementById("scene"); // stock l'element DOM <select> qui a l'id "scene"
        var len = scenesSelect.options.length; // calcul la longueur des options à effacer
        while (scenesSelect.options.length > 0) // efface tant que ce n'est pas 0
            scenesSelect.remove(0);

        var newOption; // création de nouvelles options
        for (var key in scenesList) { 
            newOption = document.createElement("option"); 
            newOption.value = key; // la valeur de l'option sera le numero de la clé associative du tableau  
            newOption.text = scenesList[key]; // le texte de l'option sera la valeur de la clé associative du tableau

            if (newOption.value == '') {
                newOption.setAttribute('disabled', true);
                newOption.setAttribute('selected', true);
            }

            // On ajoute/rattache les <options> à l'élement DOM 
            try { scenesSelect.add(newOption); } // pour IE 
            catch (e) { scenesSelect.appendChild(newOption); } 
        }
    }

</script>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
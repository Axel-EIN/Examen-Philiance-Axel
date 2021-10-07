<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container-fluid bg-light">
    <?php include DOSSIER_VIEWS . '/admin/parts/nav-admin.html.php'; ?>

    <header class="container p-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?= $h1; ?></h1>

                <?php include_once DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>

                <!-- SOUS-TITRE SI ID CHAPITRE PARENT FOURNI -->
                <?php if(!empty($chapitre_parent)): ?> 
                    <h4 class="text-center">
                        <small>pour </small>
                        <a href="<?= route('aventure&saison=' . $saison_parent->numero
                                            . '&chapitre=' . $chapitre_parent->numero
                                            . '#tete-lecture-ch' . $chapitre_parent->numero); ?>">
                            <?= $chapitre_parent->titre ?>&nbsp;<i class="fas fa-eye"></i>
                        </a>
                    </h4>
                <?php endif; ?>

            </div>
        </div>
    </header>

    <main class="container">

        <form class="col-8 offset-2 mb-5" method="post" action="<?= route('admin-creer-episode-handler' . $get_chapitre); ?>" enctype="multipart/form-data">

            <!-- TITRE -->
            <label for="titre">Titre</label>
            <input class="form-control" type="text" name="titre" id="titre"><br/>

            <div class="form-row">

                <!-- S'AFFICHE SEULEMENT SI LA SAISON EST NON FOURNI -->
                <?php if(empty($saison_parent)): ?>
                <div class="col-6">
                    <label for="saison">Choisir la saison à rattacher</label>
                    <select class="form-control" id="saison" required onchange="chapitreChange(this);">
                        <option value="">Choisir une Saison...</option>

                        <?php foreach($toutes_les_saisons as $une_saison): ?>
                            <option value="<?= $une_saison->id; ?>"><?= $une_saison->titre; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <?php endif; ?>

                <!-- S'AFFICHE SEULEMENT SI LE CHAPITRE EST NON FOURNI -->
                <?php if(empty($chapitre_parent)): ?>
                <div class="col-6">
                    <label for="chapitre">Choisir le chapitre à rattacher</label>
                    <select class="form-control" id="chapitre" name="id_chapitre" required onchange="episodeChange(this);">
                        <option value="" disabled></option>
                    </select>
                </div>
                <?php endif; ?>

            </div>
            <br/>

            <div class="form-row">
                <div class="col-12">
                    <!-- EPISODE -->
                    <label for="episode">Choisir la position de l'épisode</label>
                    <select class="form-control" id="episode" name="numero" required>

                        <?php if(empty($chapitre_parent) || empty($_GET['numero'])): ?>
                            <option value="" disabled></option>
                        <?php else: ?>
                            <?php if($episodes_enfants): ?>
                                <?php foreach($episodes_enfants as $un_episode): ?>
                                    <option value="<?= $un_episode->numero ?>"
                                        <?php if($un_episode->numero == $_GET['numero']) echo ' selected' ?>>
                                            <?= $un_episode->numero; ?> - Insérer devant <?= $un_episode->titre ?>
                                    </option>
                                <?php endforeach; ?>
                                    <option value="<?= $un_episode->numero+1; ?>"
                                        <?php if($un_episode->numero+1 == $_GET['numero']) echo ' selected'; ?>>
                                            <?= $un_episode->numero+1; ?> - Insérer en dernier
                                    </option>
                            <?php else: ?>
                                <option value="1" selected>1 - Insérer en premier</option>
                            <?php endif; ?>
                        <?php endif; ?>

                    </select>
                </div>
            </div><br/>

            <!-- RESUME -->
            <label for="resume">Bref résumé / Synopsis (2 lignes)</label>
            <textarea style="resize: none;" class="form-control" maxlength="200" name="resume" id="resume" cols="30" rows="2"></textarea><br/>

            <!-- IMAGE -->
            <label for="image">Image (facultative)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="fileHelpId">
                <label class="custom-file-label" for="image">Chargez une image...</label>
                <small id="fileHelpId" class="form-text text-muted">Taille conseillée : 960x540 minimum, rapport 16/9</small>
            </div><br/><br/>
            
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
        saisonsArray["<?= $une_saison->id ?>"] = {"" : "Choisir un Chapitre...",
            <?php foreach (chapitres_enfants_de_saison($une_saison->id) as $un_chapitre): ?>
                "<?= $un_chapitre->id; ?>" : "<?= $un_chapitre->titre; ?>",
            <?php endforeach; ?> };
    <?php endforeach; ?>

    var episodesArray = new Array(<?= count($tous_les_chapitres); ?>);
    <?php foreach ($tous_les_chapitres as $un_chapitre): ?>
        episodesArray["<?= $un_chapitre->id ?>"] = {"" : "Choisir la position de l'Episode...",
            <?php if (!empty(episodes_enfants_du_chapitre_triees_numero($un_chapitre->id))): ?>
                <?php foreach (episodes_enfants_du_chapitre_triees_numero($un_chapitre->id) as $un_episode): ?>  
                    "<?= $un_episode->numero; ?>" : "<?= $un_episode->numero ?> - Insérer devant : <?= $un_episode->titre; ?>",
                <?php endforeach; ?>
                    "<?= $un_episode->numero+1; ?>" : "<?= $un_episode->numero+1 ?> - Insérer en dernier",
            <?php else: ?>
                "1" : "1 - Ajouter en premier episode",
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
</script>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
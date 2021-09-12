<?php
// 1. Connexio à la BDD
include __DIR__ . '/connexion_bdd.php';

// 2. Inclusion des modèles et fonctions
include __DIR__ . '/modeles.php';
include_once __DIR__ . '/fonctions.php';

// 3. Je récupères (RETRIEVE) toutes les données des tables de ma BDD avec un retrieve
$episodes = Episodes::all();
$chapitres= Chapitres::all();
$saisons= Saisons::all();
$scenes= Scenes::all();

// 6. Remplissage des variables pour l'Affichage
$title_html = 'Panneau d\'Administration';

// 7. Lancement de l'Affichage avec le HTML à trous
include_once __DIR__ . './header.php';
include_once __DIR__ . './nav.php'; ?>

<section class="container">
    <form class="col-12" action="admin.php" method="post">
        <fieldset class="p-5">
            <legend>Créer un nouvel Episode :</legend>
            <div class="form-row">
                <div class="col-6">
                    <label for="episode_titre">Titre :</label><br/>
                    <input type="text" id="episode_titre" name="episode_titre" maxlength="50" placeholder="50 caractères max..." size="50"><br/><br/>           

                    <label for="episode_resume">Résumé :</label><br/>
                    <textarea name="episode_resume" id="episode_resume" cols="48" rows="5" style="resize: none;" placeholder="255 caractères max..."></textarea><br/><br/>

                    <label for="episode_image">Image de l'Episode :<br/><small class="text-muted font-italic">16/9 1200x720px conseillé</small></label><br/>
                    <input type="file" id="episode_image" name="episode_image"><br/><br/>         

                    <label for="chapitre_select">Choissisez à quel Chapitre il appartient :</label><br/>
                    <select id="chapitre_select">
                        <option value="1">S1 - Chapitre 1</option>
                        <option value="2">S1 - Chapitre 2</option>
                        <option value="3">S1 - Chapitre 3</option>
                        <option value="4">S1 - Chapitre 4</option>
                        <option value="5">S1 - Chapitre 5</option>
                        <option value="6">S1 - Chapitre 6</option>
                        <option value="7">S1 - Chapitre 7</option>
                        <option value="8">S1 - Chapitre 8</option>
                        <option value="9">S2 - Chapitre 1</option>
                        <option value="10">S2 - Chapitre 2</option>
                        <option value="0">Créer un nouveau Chapitre</option>
                    </select><br/><br/>
                </div>
                <div class="col-6">
                    <fieldset class="p-4">
                        <legend>Scènes de l'Episode :</legend>
                        <label for="scene_1_titre">Titre de la Scene n°1 :</label><br/>
                        <input type="text" id="scene_1_titre" name="scene_1_titre" maxlength="50" placeholder="50 caractères max..." size="48"><br/><br/>
                                        
                        <label for="scene_1_temps">Moment ou Temps en Jeu de la Scene n°1 :</label><br/>
                        <input type="text" id="scene_1_temps" name="scene_1_temps" maxlength="50" placeholder="50 caractères max..." size="48"><br/><br/>

                        <label for="scene_1_image">Image de la Scene n°1 :<br/><small class="text-muted font-italic">16/9 1200x720px conseillé</small></label><br/>
                        <input type="file" id="scene_1_image" name="scene_1_image"><br/><br/>

                        <label for="scene_1_texte">Texte de la Scène n°1 :</label><br/>
                        <textarea name="scene_1_texte" id="scene_1_texte" cols="46" rows="5" style="resize: none;" placeholder="Saisir le texte de la scène..."></textarea><br/><br/>
                        
                        <button>Ajouter d'autre Scènes à l'Episode</button>
                    </fieldset>
                </div>
                <div class="col-12">
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary m-3" value="Créer le nouvel Episode">
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</section>

<?php
include_once __DIR__ . './footer.php';
<?php
// 1. Connexio à la BDD
include __DIR__ . '/connexion_bdd.php';

// 2. Inclusion des modèles et fonctions
include __DIR__ . '/modeles.php';
include_once __DIR__ . '/fonctions.php';

// 3. Je récupères (RETRIEVE) les données des tables de ma BDD avec un retrieve
$scenes = Scenes::all();
$episodes = Episodes::all();
$chapitres= Chapitres::all();
$saisons= Saisons::all();

// 4. Verification de la variable global GET
if (empty($_GET['numero']))
{
    echo 'Veuillez choisir un episode à afficher!';
    die;
} else $select_episode = $_GET['numero'];

// 5. Selection et préparation des  données qu'on a besoin pour l'affichage selon le paramètre du GET
foreach ($scenes as $cle => $valeur)
{
    if ($scenes[$cle]->num_episode == $select_episode)
    {
        $select_chapitre = $scenes[$cle]->num_chapitre;
        $select_saison = $scenes[$cle]->num_saison;
    }
}

foreach ($chapitres as $cle => $valeur)
{
    if ($chapitres[$cle]->numero == $select_chapitre && $chapitres[$cle]->num_saison == $select_saison)
    {
        $titre_chapitre = $chapitres[$cle]->titre;
        $entete_chapitre = $chapitres[$cle]->entete;
        $citation_chapitre = $chapitres[$cle]->citation;
        $image_chapitre = $chapitres[$cle]->image;
        $couleur_chapitre = $chapitres[$cle]->couleur;
    }
}

foreach ($episodes as $cle => $valeur)
{
    if ($episodes[$cle]->numero == $select_episode)
    {
        $titre_episode = $episodes[$cle]->titre;

        if ($cle != 0) $previous_episode = true;
        else $previous_episode = false;

        if ($cle < sizeof($episodes)) $next_episode = true;
        else $next_episode = false;
    }
}

$title_html = 'Episode n°' . $select_chapitre . ' : ' . $titre_episode . ' | Chapitre ' . $titre_chapitre . ' | Saison ' . $select_saison;

// 11. Lancement de l'affichage avec les inclusions d'HTML à trous
include __DIR__ . '/header.php';
include __DIR__ . '/nav.php'; ?>

<!-- HEADER IMAGE + TITRE DU CHAPITRE -->
<div id="ch<?= $select_chapitre ?>-header" class="episode-fond p-md-4" style="background-image: url('<?= $image_chapitre; ?>');background-color: #<?= $couleur_chapitre ?>;">
    <header class="container">
        <div class="header">
            <h1 class="display-5">CHAPITRE <?= $select_chapitre; ?></h1>
            <hr class="my-md-2">
            <a class="btn btn-primary btn-lg" href="index.php#ch<?= $select_chapitre ?>-header" role="button">Retour au chapitre</a>
            <p class="lead" id="tete-lecture">
                <?= $entete_chapitre; ?>
            </p>
            <p class="citation"><?php echo nl2br($citation_chapitre); ?></p>
        </div>
    </header>

    <!-- RESUME DE L'EPISODE -->
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-xl-10 newpad">
                <div class="card">
                    <!-- SECTION NAVIGATION DU HAUT -->
                    <section class="d-flex p-3">
                        <div class="pr-1 text-left d-flex flex-column justify-content-center">
                            <a href="episode.php?numero=<?= $select_episode-1; ?>"
                            class="btn btn-primary <?php if (!$previous_episode): ?>disabled<?php endif ?>">Episode précédent</a>
                        </div>
                        <div class="pr-1 flex-grow-1 text-left">
                            <h2 class="text-center py-3">
                                <p>
                                    <span class="display-4">- <?= $select_episode; ?> -</span>
                                    <br/>
                                    <span class=""><?= $titre_episode; ?></span>
                                </p>
                            </h2>
                        </div>
                        <div class="pl-1 text-right d-flex flex-column justify-content-center">
                            <a href="episode.php?numero=<?= $select_episode+1; ?>"
                            class="btn btn-primary <?php if (!$next_episode): ?>disabled<?php endif ?>">Episode suivant</a>
                        </div>
                    </section>
                    <!-- SECTION CORPS DU RESUME : AFFICHAGE DES SCENES -->
                    <section>
                        <?php
                            foreach ($scenes as $cle => $valeur)
                            {
                                if ($scenes[$cle]->num_episode == $select_episode)
                                    afficher_une_scene($scenes[$cle]);
                            }
                        ?>
                    </section>
                    <!-- SECTION NAVIGATION DU BAS -->
                    <section class="d-flex justify-content-center p-4">
                        <div class="col py0 pl-0 pr-2">
                            <a href="episode.php?numero=<?= $select_episode-1; ?>"
                            class="btn btn-primary <?php if (!$previous_episode): ?>disabled<?php endif ?>">Episode précédent</a>
                        </div>
                        <div>
                            <a href="index.php#ch<?= $select_chapitre ?>-header" class="btn btn-primary">Retour au chapitre</a>
                        </div>
                        <div class="col py-0 pr-0 pl-2 text-right">
                            <a href="episode.php?numero=<?= $select_episode+1; ?>"
                            class="btn btn-primary <?php if (!$next_episode): ?>disabled<?php endif ?>">Episode suivant</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include __DIR__ . '/modal.php';
include __DIR__ . '/footer.php';
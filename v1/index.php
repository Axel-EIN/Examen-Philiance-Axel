<?php
// 1. Connexio à la BDD
include __DIR__ . '/connexion_bdd.php';

// 2. Inclusion des modèles et fonctions
include __DIR__ . '/modeles.php';
include_once __DIR__ . '/fonctions.php';

// 3. Je récupères (RETRIEVE) les données des tables de ma BDD avec un retrieve
$episodes = Episodes::all();
$chapitres= Chapitres::all();
$saisons= Saisons::all();

// 4. Verification de la variable global GET
if (empty($_GET['saison'])) $select_saison = 1;
else $select_saison = $_GET['saison'];

// 5. Selection des données qu'on a besoin selon le paramètres get;
$total_saisons = sizeof($saisons);
foreach ($saisons as $cle => $valeur)
{
    if ($saisons[$cle]->numero == $select_saison)
    {
        $numero_saison = $saisons[$cle]->numero;
        $titre_saison = $saisons[$cle]->titre;
        $entete_saison = $saisons[$cle]->entete;
        $image_saison = $saisons[$cle]->image;
        $couleur_saison = $saisons[$cle]->couleur;
    }
}

// 6. Remplissage des variables pour l'Affichage
$title_html = $titre_saison . ' | Saison n°' . $numero_saison . ' d\'une Aventure dans ' . 'Le Livre des Cinq Anneaux';

// 7. Lancement de l'Affichage avec le HTML à trous
include_once __DIR__ . './header.php';
include_once __DIR__ . './nav.php'; ?>

<!-- HEADER SAISON -->
<header id="header-s<?= $numero_saison; ?>" class="header-fond py-md-4 py-sm-2" style="background-image: linear-gradient(rgb(40,0,0,0.5),rgb(40,0,0,0.5)),url('<?= $image_saison; ?>');">
    <div class="container">
        <div class="header">
            <h1 class="display-5 text-center">
                <div class="d-flex w-100 justify-content-center">
                    <div class="text-center" style="width: 64px">
                        <?php if ($numero_saison > 1): ?>
                            <a href="index.php?saison=<?= $numero_saison-1; ?>">
                                <button class="btn btn-primary btn-lg text-center btn-saison" type="button"><</button>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div>
                        SAISON <?= $numero_saison ?>
                    </div>
                    <div class="text-center" style="width: 64px">
                        <?php if ($numero_saison < $total_saisons): ?>
                            <a href="index.php?saison=<?= $numero_saison+1; ?>">
                                <button class="btn btn-primary btn-lg text-center btn-saison" type="button">></button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </h1>
            <hr class="w-50">
            <p class="lead">
                <?= $entete_saison; ?>
            </p>
        </div>
    </div>
</header>

<!-- AFFICHAGE DES CHAPITRES DE LA SAISON -->
<main>
    <div id="liste-ch" class="pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="display-4 text-center pb-3">Liste des Chapitres</h2>
                </div>
            </div>
        </div>
    </div>
    <?php
        $filter_chapitres = [];
        foreach($chapitres as $cle => $valeur)
        {
            if ($chapitres[$cle]->num_saison == $numero_saison)
                array_push($filter_chapitres, $chapitres[$cle]);
        }

        foreach($filter_chapitres as $cle => $valeur)
        {
            $filter_episodes = [];
            foreach($episodes as $cle_ep => $valeur_ep)
            {
                if ($episodes[$cle_ep]->num_chapitre == $filter_chapitres[$cle]->numero && $episodes[$cle_ep]->num_saison == $numero_saison)
                    array_push($filter_episodes, $episodes[$cle_ep]);
            }
            afficher_un_chapitre($filter_chapitres[$cle], $filter_episodes);
        }
    ?>
</main>

<?php include_once __DIR__ . './footer.php'; ?>
<?php include_once __DIR__ . './modal.php'; ?>
<script src="script.js"></script>
</body>
</html>
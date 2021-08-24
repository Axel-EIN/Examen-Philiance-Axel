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

<div class="container pt-5">
    <header class="row">
        <div class="col-12"><h1 class="text-center">Bienvenue dans le Panneau d'Administration !</h1></div>
    </header>
</div>
<main class="container">
    <style>
        .petit{
            font-family: "Shogun";
            font-size: 0.5em;
        }

        .moyen{
            font-family: "Shogun";
            font-size: 1.25em;
        }

        .grand{
            font-family: "Shogun";
            font-size: 1.5em;
        }
    </style>
    <!-- AFFICHAGE ADMIN : LISTE EPISODES -->
    <section class="row my-5 py-2">
        <div class="col-12">
            <h3 class="py-3">Episodes enregistrés :</h3>
            <table class="w-100">
                <tr>
                    <th class="p-2 border">N°</th>
                    <th class="p-2 border">Saison</th>
                    <th class="p-2 border">Chapitre</th>
                    <th class="p-2 border">Titre</th>
                    <th class="p-2 border">Resumé</th>
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                </tr>
            <?php
                foreach($episodes as $key => $value)
                { ?>
                    <tr>
                        <td class="p-2 border text-center"><?= $episodes[$key]->numero; ?></td>
                        <td class="p-2 border text-center"><?= $episodes[$key]->num_saison; ?></td>
                        <td class="p-2 border text-center"><?= $episodes[$key]->num_chapitre; ?></td>
                        <td class="p-2 border"><strong><?= $episodes[$key]->titre; ?></strong></td>
                        <td class="p-2 border"><small><?= $episodes[$key]->resume; ?></small></td>
                        <td class="p-2 border"><?= $episodes[$key]->image; ?></td>
                        <td class="p-2 border text-center"><a href="episode.php?numero=<?= $episodes[$key]->numero; ?>">Voir</a></td>
                        <td class="p-2 border text-center"><a href="admin_modifier_episode?numero=<?= $episodes[$key]->numero; ?>">Modif.</a></td>
                        <td class="p-2 border text-center"><a href="#">Suppr.</a></td>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <a href="admin_creer_episode.php">
                <button class="btn btn-primary">Créer un nouvel Episode</button>
            </a>
        </div>
    </section>
    <!-- AFFICHAGE ADMIN : LISTE CHAPITRES -->
    <section class="row my-5 py-2">
        <div class="col-12">
            <h3 class="py-3">Chapitres enregistrés :</h3>
            <table class="w-100">
                <tr>
                    <th class="p-2 border">N°</th>
                    <th class="p-2 border">Saison</th>
                    <th class="p-2 border">Titre</th>
                    <th class="p-2 border">En-Tête</th>
                    <th class="p-2 border">Citation</th>
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border">Couleur</th>
                    <th class="p-2 border">MJ</th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                </tr>
            <?php
                foreach($chapitres as $key => $value)
                { ?>
                    <tr>
                        <td class="p-2 border text-center"><?= $chapitres[$key]->numero; ?></td>
                        <td class="p-2 border text-center"><?= $chapitres[$key]->num_saison; ?></td>
                        <td class="p-2 border"><strong><?= $chapitres[$key]->titre; ?></strong></td>
                        <td class="p-2 border"><?= $chapitres[$key]->entete; ?></td>
                        <td class="p-2 border"><small><?= $chapitres[$key]->citation; ?></small></td>
                        <td class="p-2 border"><?= $chapitres[$key]->image; ?></td>
                        <td class="p-2 border text-center"><?= $chapitres[$key]->couleur; ?></td>
                        <td class="p-2 border"><?= $chapitres[$key]->mj; ?></td>
                        <td class="p-2 border text-center"><a href="index.php?saison=<?= $chapitres[$key]->num_saison; ?>#ch<?= $chapitres[$key]->numero; ?>-header">Voir</a></td>
                        <td class="p-2 border text-center"><a href="admin_modifier_chapitre?id=<?= $chapitres[$key]->id; ?>">Modif.</a></td>
                        <td class="p-2 border text-center"><a href="#">Suppr.</a></td>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <a href="admin_creer_chapitre.php">
                <button class="btn btn-primary">Créer un nouveau Chapitre</button>
            </a>
        </div>
    </section>
    <!-- AFFICHAGE ADMIN : LISTE SAISONS -->
    <section class="row my-5 py-2">
        <div class="col-12">
            <h3 class="py-3">Saison enregistrés :</h3>
            <table class="w-100">
                <tr>
                    <th class="p-2 border">N°</th>
                    <th class="p-2 border">Titre</th>
                    <th class="p-2 border">En-Tête</th>
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border">Couleur</th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                    <th class="p-2 border"></th>
                </tr>
            <?php
                foreach($saisons as $key => $value)
                { ?>
                    <tr>
                        <td class="p-2 border text-center"><?= $saisons[$key]->numero; ?></td>
                        <td class="p-2 border"><strong><?= $saisons[$key]->titre; ?></strong></td>
                        <td class="p-2 border"><strong><?= $saisons[$key]->entete; ?></strong></td>
                        <td class="p-2 border"><?= $saisons[$key]->image; ?></td>
                        <td class="p-2 border text-center"><?= $saisons[$key]->couleur; ?></td>
                        <td class="p-2 border text-center"><a href="index.php?saison=<?= $saisons[$key]->numero; ?>">Voir</a></td>
                        <td class="p-2 border text-center"><a href="admin_saison.php?numero=<?= $saisons[$key]->numero; ?>">Modif.</a></td>
                        <td class="p-2 border text-center"><a href="#">Suppr.</a></td>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <a href="admin_creer_saison.php">
                <button class="btn btn-primary">Créer une nouvelle Saison</button>
            </a>
        </div>
    </section>
</main>

<?php
include_once __DIR__ . './footer.php';
<?php

if(!admin_connecte()) redirection('403', 'Accès non-autorisée!');

include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<header class="container pt-5">
    <div class="row">
        
        <div class="col-12">
            <h1 class="text-center">Bienvenue dans le Panneau d'Administration !</h1>
        </div>

        <!-- ALERTE -->
        <?php if (!empty($_GET['alerte'])): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3 mx-auto" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>Opération réussie!</strong> <?= $_GET['alerte']; ?>
            </div>
        <?php endif; ?>
        <!-- FIN : ALERTE -->

    </div>
</header>

<main class="container">

    <!-- AFFICHAGE ADMIN : LISTE SCENES -->
    <section id="scenes" class="row my-5 py-2">

        <div class="col-8">
            <h3 class="py-3">Scenes :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-scene'); ?>"><button class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer une nouvelle Scène</button></a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <td class="p-2 text-center">ID</td>
                    <td class="p-2 text-center">N°</td>
                    <td class="p-2 text-center">de l'episode :</td>
                    <td class="p-2">Titre</td>
                    <td class="p-2">Temps dans le jeu</td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>

                </tr>
                <tr><td class="p-2" colspan="9"></td></tr>
                <?php foreach ($scenes as $une_scene): ?>
                    <tr>
                        <td class="p-2 border text-center"><strong><?= $une_scene->id; ?></strong></td>
                        <td class="p-2 border text-center"><?= $une_scene->numero; ?></td>
                        <td class="p-2 border text-center">Episode&nbsp;<?= $une_scene->id_episode; ?></td>
                        <td class="p-2 border"><strong><?= $une_scene->titre; ?></strong></td>
                        <td class="p-2 border"><small><?= $une_scene->temps; ?></small></td>
                        <td class="p-2 border text-center"><a href="<?= route('episode&id=' . $une_scene->id_episode . '#scn' . $une_scene->numero); ?>"><i class="fas fa-eye"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin-modifier-scene&id=' . $une_scene->id); ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin-supprimer-scene-handler&id=' . $une_scene->id, 'administration'); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la scène : <?= $une_scene->titre ?> ?')"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <tr class="border">
                        <td class="col-3 border p-2 bg-light" rowspan="2" colspan="3"><img src="<?= url_img($une_scene->image); ?>" class="img-fluid" /></td>
                        <td class="p-2 border" colspan="7"><small><?= $une_scene->texte; ?></small></td>
                    </tr>
                    <tr class="border">
                        <td class="p-2 border bg-light" colspan="5"><strong class="text-secondary">Participants&nbsp;:</strong></td>
                    </tr>
                    <tr><td class="p-2" colspan="9"></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>

    <!-- AFFICHAGE ADMIN : LISTE EPISODES -->
    <section class="row my-5 py-2">

        <div class="col-8">
            <h3 class="py-3">Episodes :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-episode'); ?>">
                <button class="btn btn-primary">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un nouvel Episode
                </button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <td class="p-2 text-center">Image</td>
                    <td class="p-2 text-center">ID</td>
                    <td class="p-2 text-center">N°</td>
                    <td class="p-2 text-center">du Chapitre :</td>
                    <td class="p-2">Titre</td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                </tr>
                <tr><td class="p-2" colspan="8"></td></tr>
                <?php foreach ($episodes as $un_episode): ?>
                    <tr>
                        <td class="p-2 border bg-light text-center" rowspan="2">
                            <img src="<?= url_img($un_episode->image); ?>" class="img-fluid" style="max-height: 240px;" />
                        </td>
                        <td class="p-2 border text-center"><strong><?= $un_episode->id; ?></strong></td>
                        <td class="p-2 border text-center"><strong><?= $un_episode->numero; ?></strong></td>
                        <td class="p-2 border text-center">Chapitre &nbsp;<?= $un_episode->id_chapitre; ?></td>
                        <td class="p-2 border"><strong><?= $un_episode->titre; ?></strong></td>
                        <td class="p-2 border text-center"><a href="<?= route('episode&id=' . $un_episode->id . '#tete-lecture'); ?>"><i class="fas fa-eye"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin-modifier-episode&id=' . $un_episode->id); ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('supprimer?id=' . $un_episode->id); ?>"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="p-2 border" colspan="7"><strong>Résumé :</strong><br/><small><?= $un_episode->resume; ?></small></td>
                    </tr>
                    <tr><td class="p-2" colspan="7"></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>
    
    <!-- AFFICHAGE ADMIN : LISTE CHAPITRES -->
    <section class="row my-5 py-2">
        <div class="col-8">
            <h3 class="py-3">Chapitres :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="admin_creer_chapitre.php"><button class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un nouveau Chapitre</button></a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <th class="p-2">N°</th>
                    <th class="p-2"></th>
                    <th class="p-2">Titre</th>
                    <th class="p-2">Image</th>
                    <th class="p-2">Couleur</th>
                    <th class="p-2">MJ ID</th>
                    <th class="p-2"></th>
                    <th class="p-2"></th>
                    <th class="p-2"></th>
                </tr>
                <tr><td class="p-2" colspan="9"></td></tr>
                <?php foreach ($chapitres as $un_chapitre): ?>
                    <tr>
                        <td class="p-2 border text-center"><strong><?= $un_chapitre->numero; ?></strong></td>
                        <td class="p-2 border text-center">Saison <?= $un_chapitre->id_saison; ?></td>
                        <td class="p-2 border"><strong><?= $un_chapitre->titre; ?></strong></td>
                        <td class="p-2 border"><?= url_img($un_chapitre->image); ?></td>
                        <td class="p-2 border text-center"><?= $un_chapitre->couleur; ?></td>
                        <td class="p-2 border"><?= $un_chapitre->id_mj; ?></td>
                        <td class="p-2 border text-center"><a href="<?= route('aventure&saison=' . $un_chapitre->id_saison . '#ch' . $un_chapitre->numero . '-header'); ?>"><i class="fas fa-eye"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin_modifier_chapitre&id=' . $un_chapitre->id); ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin_supprimer_chapitre&id=' . $un_chapitre->id); ?>"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center bg-light" colspan="2"><strong>Citation :</strong></td>
                        <td class="p-2 border text-center" colspan="7"><small><?= $un_chapitre->citation; ?></small></td>
                    </tr>
                    <tr><td class="p-2" colspan="9"></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>

    <!-- AFFICHAGE ADMIN : LISTE SAISONS -->
    <section class="row my-5 py-2">
        <div class="col-8">
            <h3 class="py-3">Saisons :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="admin_creer_saison.php"><button class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer une nouvealle Saison</button></a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <th class="p-2">N°</th>
                    <th class="p-2">Titre</th>
                    <th class="p-2">Image</th>
                    <th class="p-2">Couleur</th>
                    <th class="p-2"></th>
                    <th class="p-2"></th>
                    <th class="p-2"></th>
                </tr>
                <?php foreach($saisons as $une_saison) : ?>
                    <tr>
                        <td class="p-2 border text-center"><?= $une_saison->numero; ?></td>
                        <td class="p-2 border"><strong><?= $une_saison->titre; ?></strong></td>
                        <td class="p-2 border"><?= url_img($une_saison->image); ?></td>
                        <td class="p-2 border text-center"><?= $une_saison->couleur; ?></td>
                        <td class="p-2 border text-center"><a href="<?= route('aventure&saison=' . $une_saison->id); ?>"><i class="fas fa-eye"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin_modifier_saison&id=' . $une_saison->id); ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="p-2 border text-center"><a href="<?= route('admin_supprimer_saison&id=' . $une_saison->id); ?>"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
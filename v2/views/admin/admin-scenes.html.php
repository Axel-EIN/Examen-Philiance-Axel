<?php if(!admin_connecte()) redirection('403', 'Accès non-autorisée!'); ?>
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<header class="container pt-5">
    <div class="row justify-content-center">
        
        <div class="col-12">
            <h1 class="text-center">Bienvenue dans le Panneau d'Administration !</h1>
        </div>

        <?php include DOSSIER_VIEWS . '/parts/nav-admin.html.php'; ?>

        <div class="col-12">
            <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
        </div>

    </div>
</header>

<main class="container">

    <!-- AFFICHAGE ADMIN : LISTE SCENES -->
    <section id="scenes" class="row my-3 py-2">

        <div class="col-8">
            <h3 class="py-3">Scènes :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-scene'); ?>">
                <button class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer une nouvelle scène</button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">

                <tr class="bg-dark text-light">
                    <td class="p-2 text-center">ID</td>
                    <td class="p-2 text-center">N°</td>
                    <td class="p-2 text-center">Rattachée à</td>
                    <td class="p-2">Titre</td>
                    <td class="p-2">Temps dans le jeu</td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                </tr>
                
                <tr><td class="p-2" colspan="9"></td></tr>

                <?php foreach ($scenes as $une_scene): ?>
                    <?php $episode_parent = episode_trouve_par_id($une_scene->id_episode); ?>
                    <?php $chapitre_parent = chapitre_trouve_par_id($episode_parent->id_chapitre); ?>
                    <?php $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison); ?>

                    <tr>
                        <td class="p-2 border text-center"><strong><?= $une_scene->id; ?></strong></td>
                        <td class="p-2 border text-center"><strong>Scène&nbsp;<?= $une_scene->numero; ?></strong></td>
                        <td class="p-2 border text-center">
                            Saison<?= $saison_parent->numero; ?> > Chapitre<?= $chapitre_parent->numero; ?> > Episode<?= $une_scene->id_episode; ?>
                        </td>
                        <td class="p-2 border"><strong><?= $une_scene->titre; ?></strong></td>
                        <td class="p-2 border"><small><?= $une_scene->temps; ?></small></td>

                        <td class="p-2 border text-center">
                            <a href="<?= route('episode&id=' . $une_scene->id_episode . '#scn' . $une_scene->numero); ?>">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-modifier-scene&id=' . $une_scene->id); ?>"><i class="fas fa-edit"></i></a>
                        </td>

                        <td class="p-2 border text-center">
                            <a  href="<?= route('admin-supprimer-scene-handler&id=' . $une_scene->id, 'administration'); ?>"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer la scène : <?= $une_scene->titre ?> ?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>

                    </tr>
                    <tr class="border">

                        <td class="col-3 border p-2 bg-light" rowspan="2" colspan="3">
                            <img src="<?= url_img($une_scene->image); ?>" class="img-fluid" />
                        </td>
                        
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

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
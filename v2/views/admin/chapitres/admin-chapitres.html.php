<?php if(!admin_connecte()) redirection('403', 'Accès non-autorisé !'); ?>
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
    
    <!-- AFFICHAGE ADMIN : LISTE CHAPITRES -->
    <section id="chapitres" class="row my-3 py-2">
        
        <div class="col-8">
            <h3 class="py-3">Chapitres :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-chapitre'); ?>">
                <button class="btn btn-primary">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un nouveau chapitre
                </button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <th class="p-2 text-center">Image</th>
                    <th class="p-2 text-center">ID</th>
                    <th class="p-2 text-center">N°</th>
                    <th class="p-2 text-center">Rattaché à</th>
                    <th class="p-2">Titre</th>
                    <th class="p-2 text-center">Couleur</th>
                </tr>
                <tr><td class="p-2" colspan="9"></td></tr>
                <?php foreach ($chapitres as $un_chapitre): ?>
                <?php $saison_parent = saison_trouve_par_id($un_chapitre->id_saison); ?>

                    <tr>
                        <td class="p-2 border bg-light text-center" rowspan="4">
                            <img src="<?= url_img($un_chapitre->image); ?>" class="img-fluid" style="max-height: 320px;" />
                        </td>
                        <td class="p-2 border text-center"><strong><?= $un_chapitre->id; ?></strong></td>
                        <td class="p-2 border text-center"><strong>Chapitre <?= $un_chapitre->numero; ?></strong></td>
                        <td class="p-2 border text-center">Saison <?= $saison_parent->numero; ?></td>
                        <td class="p-2 border"><strong><?= $un_chapitre->titre; ?></strong></td>
                        <td class="p-1 border">
                            <div class="mx-auto" style="width: 36px; height: 24px; background-color: <?= $un_chapitre->couleur; ?>"> </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border align-top" rowspan="2" colspan="4">
                            <strong>Citation :</strong><br/><small><?= $un_chapitre->citation; ?></small>
                        </td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('aventure&saison=' . $saison_parent->numero . '#ch' . $un_chapitre->numero . '-header'); ?>">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-modifier-chapitre&id=' . $un_chapitre->id); ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border align-middle" colspan="4">
                            <strong>Maître du Jeu :</strong> <?= utilisateur_trouve_par_id($un_chapitre->id_mj)->prenom; ?>
                        </td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-supprimer-chapitre-handler&id=' . $un_chapitre->id, 'administration-chapitres'); ?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer le chapitre : <?= $un_chapitre->titre ?> ?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <tr><td class="p-2" colspan="11"></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
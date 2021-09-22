<?php if(!admin_connecte()) redirection('403', 'Accès non-autorisée!'); ?>
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<header class="container pt-5">
    <div class="row justify-content-center">
        
        <div class="col-12">
            <h1 class="text-center">Bienvenue dans le Panneau d'Administration !</h1>
        </div>

        <?php include DOSSIER_VIEWS . '/parts/alerte.html.php'; ?>
        <?php include DOSSIER_VIEWS . '/parts/nav-admin.html.php'; ?>

    </div>
</header>

<main class="container">
    
    <!-- AFFICHAGE ADMIN : LISTE CHAPITRES -->
    <section class="row my-5 py-2">
        <div class="col-8">
            <h3 class="py-3">Chapitres :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="admin_creer_chapitre.php">
                <button class="btn btn-primary">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un nouveau Chapitre
                </button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <th class="p-2">Image</th>
                    <th class="p-2">ID</th>
                    <th class="p-2">N°</th>
                    <th class="p-2">rattaché à la Saison :</th>
                    <th class="p-2">Titre</th>
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

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
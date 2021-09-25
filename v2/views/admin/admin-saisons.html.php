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

    <!-- AFFICHAGE ADMIN : LISTE SAISONS -->
    <section class="row my-5 py-2">
        <div class="col-8">
            <h3 class="py-3">Saisons :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="admin_creer_saison.php"><button class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer une nouvelle saison</button></a>
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
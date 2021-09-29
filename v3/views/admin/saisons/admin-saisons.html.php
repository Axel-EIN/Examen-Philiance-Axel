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

    <!-- AFFICHAGE ADMIN : LISTE SAISONS -->
    <section id="saisons" class="row my-3 py-2">
        
        <div class="col-8">
            <h3 class="py-3">Saisons :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-saison'); ?>">
                <button class="btn btn-primary">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer une nouvelle saison
                </button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <th class="p-2">Image</th>
                    <th class="p-2" colspan="3">Titre</th>
                    <th class="p-2">Actions</th>
                </tr>

                <?php foreach($saisons as $une_saison) : ?>
                    <tr><td class="p-2" colspan="5"></td></tr>
                    <tr>
                        <td class="p-2 border text-center bg-light" rowspan="3">
                            <img class="img-fluid" style="width: 540px" src="<?= url_img($une_saison->image); ?>" alt="Image du Chapitre" />
                        </td>
                        <td class="p-2 border text-center" colspan="3" rowspan="2"><strong><?= $une_saison->titre; ?></strong></td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('aventure&saison=' . $une_saison->numero); ?>"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-modifier-saison&id=' . $une_saison->id); ?>"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center"><strong>ID :</strong><br/><?= $une_saison->id; ?></td>
                        <td class="p-2 border text-center"><strong>N° :</strong><br/><?= $une_saison->numero; ?></td>
                        <td class="p-2 border text-center"><strong>Couleur :</strong><br/><?= $une_saison->couleur; ?></td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-supprimer-saison-handler&id=' . $une_saison->id, 'administration-saisons'); ?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer la saison : <?= $une_saison->titre ?> ?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </section>

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
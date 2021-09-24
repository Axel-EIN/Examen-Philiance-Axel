<?php

if(!admin_connecte()) redirection('403', 'Accès non-autorisée!');

include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

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

    <!-- AFFICHAGE ADMIN : LISTE EPISODES -->
    <section class="row my-5 py-2">

        <div class="col-8">
            <h3 class="py-3">Episodes :</h3>
        </div>
        <div class="col-4 text-right my-3">
            <a href="<?= route('admin-creer-episode'); ?>">
                <button class="btn btn-primary">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Créer un nouvel episode
                </button>
            </a>
        </div>
        <div class="col-12">
            <table class="w-100">
                <tr class="bg-dark text-light">
                    <td class="p-2 text-center">Image</td>
                    <td class="p-2 text-center">ID</td>
                    <td class="p-2 text-center">N°</td>
                    <td class="p-2 text-center">Ratraché à</td>
                    <td class="p-2">Titre</td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                </tr>
                <tr><td class="p-2" colspan="8"></td></tr>
                <?php foreach ($episodes as $un_episode): ?>
                <?php $chapitre_parent = chapitre_trouve_par_id($un_episode->id_chapitre); ?>
                <?php $saison_parent = saison_trouve_par_id($chapitre_parent->id_saison); ?>

                    <tr>
                        <td class="p-2 border bg-light text-center" rowspan="2">
                            <img src="<?= url_img($un_episode->image); ?>" class="img-fluid" style="max-height: 240px;" />
                        </td>
                        <td class="p-2 border text-center"><strong><?= $un_episode->id; ?></strong></td>
                        <td class="p-2 border text-center"><strong>Episode&nbsp;<?= $un_episode->numero; ?></strong></td>
                        <td class="p-2 border text-center">
                            Saison<?= $saison_parent->numero; ?> Chapitre<?= $chapitre_parent->numero; ?>
                        </td>
                        <td class="p-2 border"><strong><?= $un_episode->titre; ?></strong></td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('episode&id=' . $un_episode->id . '#tete-lecture'); ?>">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-modifier-episode&id=' . $un_episode->id); ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td class="p-2 border text-center">
                            <a href="<?= route('admin-supprimer-episode-handler&id=' . $un_episode->id, 'administration-episodes'); ?>"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'épisode : <?= $un_episode->titre ?> ?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border" colspan="7"><strong>Résumé :</strong><br/><small><?= $un_episode->resume; ?></small></td>
                    </tr>
                    <tr><td class="p-2" colspan="9"></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>
    
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
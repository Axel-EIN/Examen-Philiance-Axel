<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid">
    <section class="container">
        <h1><?= $personnage_trouve->nom; ?> <?= $personnage_trouve->prenom; ?></h1>

            <article class="row">
                <div class="col-6">
                    <img class="img-fluid" src="<?= url_img($personnage_trouve->illustration); ?>" />
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <h4 class="card-title"><?= $personnage_trouve->nom; ?> <?= $personnage_trouve->prenom; ?></h4>
                        <p class="card-text"><?= $personnage_trouve->titres; ?></p>
                        <p class="card-text"><?= $personnage_trouve->description; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><div class="d-inline-block">Rang (niveau)<br/><strong class="display-4"><?= $rang; ?></strong></div> &nbsp; &nbsp; &nbsp; <div class="d-inline-block">points d'experience :<br/><strong class="display-4"><?= $total_xp; ?>xp</strong></div></li>
                        <li class="list-group-item">
                            <div class="d-inline-block">Clan :<br/>
                                <img style="width: 64px;" src="<?= url_img($personnage_clan->mon) ?>" alt="Image du Mon du Clan" />
                                <strong style="color:<?= $personnage_clan->couleur ?>;"><?= $personnage_clan->nom; ?></strong>
                            </div> &nbsp; &nbsp; &nbsp;
                            <div class="d-inline-block">Classe :<br/>
                                <strong><?= $personnage_classe->nom; ?></strong>
                            </div>
                        </li>
                        <li class="list-group-item">Ecole: <?= $personnage_ecole->nom; ?></li>
                        <li class="list-group-item">Technique Rang 1 : <?= $personnage_ecole->technique1_nom; ?><br/><small><?= $personnage_ecole->technique1_desc; ?></small></li>
                        <li class="list-group-item">Joueur: <?= $personnage_utilisateur->prenom; ?></li>
                    </ul>
                </div>
                <div class="col-12">
                    <h2>Historique</h2>
                    <?php foreach($participations_du_personnage as $une_participation): ?>
                        <?php $une_scene_trouvee = scene_trouve_par_id($une_participation->scene_id); ?>
                        <?php $episode_parent = episode_trouve_par_id($une_scene_trouvee->id_episode); ?>
                        <?php if($une_participation->est_mort == 0): ?>
                            <?= $personnage_trouve->prenom; ?> a gagné <strong><?= $une_participation->exp_gagne; ?>xp</strong> dans la scène <a href="<?= route('episode&id=' . $episode_parent->id . '#scn' . $une_scene_trouvee->numero); ?>" ><strong><?= $une_scene_trouvee->titre; ?></strong></a> de l'episode <strong><?= $episode_parent->titre; ?></strong><br/>
                        <?php else: ?>
                            <?= $personnage_trouve->prenom; ?> <strong style="color: red">est mort</strong> dans la scène <a href="<?= route('episode&id=' . $episode_parent->id . '#scn' . $une_scene_trouvee->numero); ?>" ><strong><?= $une_scene_trouvee->titre; ?></strong></a> de l'episode <strong><?= $episode_parent->titre; ?></strong><br/>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </article>

    </section>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid bg-light">
    <section class="container">
        <h1 class="pt-3 mb-3">
            <?= $personnage_trouve->nom; ?> <strong><?= $personnage_trouve->prenom; ?></strong>
            <?php if(utilisateur_connecte() && $_SESSION['id'] == $personnage_trouve->utilisateur_id): ?>
                <span class="float-right">
                    <a href="<?= route('fiche-personnage&id=' . $personnage_trouve->id); ?>">
                        <i class="fas fa-user-secret"></i> Voir Fiche Privée
                    </a>
                </span>
            <?php endif; ?>
        </h1>

            <article class="row">
                <div class="col-6">
                    <img class="img-fluid" src="<?= url_img($personnage_trouve->illustration); ?>" />
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <h4 class="card-title"><?= $personnage_trouve->titres; ?></h4>
                        <p class="card-text"><strong>Description :</strong></p>
                        <p class="card-text"><?= $personnage_trouve->description; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>Clan&nbsp;:<br/><strong style="color:<?= $personnage_clan->couleur ?>;"><?= $personnage_clan->nom; ?></strong>
                                <br/><img style="width: 64px;" src="<?= url_img($personnage_clan->mon) ?>" alt="Image du Mon du Clan" /></span>
                                <span>Classe&nbsp;:<br/><strong><?= $personnage_classe->nom; ?></strong></span>
                                <span>Ecole&nbsp;:<br/><strong><?= $personnage_ecole->nom; ?></strong></span>
                                <span>Rang&nbsp;:<br/><strong class="display-4"><?= $rang; ?></strong></span>
                                <span>XP&nbsp;:<br/><strong class="display-4"><?= $total_xp; ?></strong></span>
                            </div>
                        </li>
                        <li class="list-group-item">Technique Rang 1 : <strong><?= $personnage_ecole->technique1_nom; ?></strong><br/><small><?= $personnage_ecole->technique1_desc; ?></small></li>
                        <li class="list-group-item">Joueur: <strong><?= $personnage_utilisateur->prenom; ?></strong></li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="card my-3 ml-2 card-body">
                        <h2 class="card-title">Historique</h2>
                        <div class="card-text ml-3">
                            <?php foreach($participations_du_personnage as $une_participation): ?>
                                <?php $une_scene_trouvee = scene_trouve_par_id($une_participation->scene_id); ?>
                                <?php $episode_parent = episode_trouve_par_id($une_scene_trouvee->id_episode); ?>
                                <?php if($une_participation->est_mort == 0): ?>
                                    a
                                    <?php if($une_participation->exp_gagne == 0): ?>
                                        participé 
                                    <?php else: ?>
                                        gagné <strong><?= $une_participation->exp_gagne; ?>xp</strong> 
                                    <?php endif; ?>
                                        dans la scène <a href="<?= route('episode&id=' . $episode_parent->id . '#scn' . $une_scene_trouvee->numero); ?>" ><strong><?= $une_scene_trouvee->titre; ?></strong></a> de l'episode <strong><?= $episode_parent->titre; ?></strong><br/>
                                <?php else: ?>
                                    <?= $personnage_trouve->prenom; ?> <strong style="color: red">est mort</strong> dans la scène <a href="<?= route('episode&id=' . $episode_parent->id . '#scn' . $une_scene_trouvee->numero); ?>" ><strong><?= $une_scene_trouvee->titre; ?></strong></a> de l'episode <strong><?= $episode_parent->titre; ?></strong><br/>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </article>

    </section>
</main>
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
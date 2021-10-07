<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid bg-light">
    <section class="container">
        <h1 class="my-3">Fiche personnage privée</h1>
        <article class="card mt-3 p-3">
            <div class="row card-body">
                <div class="col-8 card-text">
                    <h2 class="mb-4">
                        <?= $personnage_trouve->nom; ?> <strong><?= $personnage_trouve->prenom; ?></strong> (<?= $personnage_utilisateur->prenom; ?>)
                    </h2>
                    <div class="row">

                        <div class="col-4 card-text">
                            <ul>
                                <li>Clan : <strong><?= $personnage_clan->nom; ?></strong></li>
                                <li>Classe : <strong><?= $personnage_classe->nom; ?></strong></li>
                                <li>Ecole : <strong><?= $personnage_ecole->nom; ?></strong></li>
                                <li>XP Création : <?php if(!empty($fiche_personnage)): ?>
                                                    <strong><?= $fiche_personnage->xp_creation; ?>xp</strong>
                                                  <?php endif; ?></li>
                            </ul>
                        </div>
                        <div class="col-4 card-text">
                            <ul>
                                <li>Rang : <strong><?= calcul_rang(somme_xp_participations_personnage($personnage_trouve->id)); ?></strong></li>
                                <li>Experience : <strong><?= somme_xp_participations_personnage($personnage_trouve->id); ?></strong></li>
                                <li>Reste : <strong>0</strong></li>
                                <li>Réputation : <strong>0</strong></li>
                            </ul>
                        </div>
                        <div class="col-4 card-text">
                            <ul>
                                <li>Honneur : <strong>0</strong></li>
                                <li>Gloire : <strong>0</strong></li>
                                <li>Infamie : <strong>0</strong></li>
                                <li>Souillure : <strong>0</strong></li>
                            </ul>
                        </div>

                        <div class="col-12 card-text">
                            <hr>
                            <?php if(!empty($fiche_personnage)): ?>
                                <div class="row text-center">
                                    <div class="col-4 offset-2">
                                        <span class="display-4"><?= min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></span>
                                        <br/>Anneau de Terre
                                        <br/><strong>Constitution : <?= $fiche_personnage->constitution; ?></strong>
                                        <br/><strong>Volonté : <?= $fiche_personnage->volonte; ?></strong>
                                    </div>
                                    <div class="col-4">
                                        <span class="display-4"><?= min($fiche_personnage->reflexes, $fiche_personnage->intuition); ?></span>
                                        <br/>Anneau de l'Air
                                        <br/><strong>Relfexes : <?= $fiche_personnage->reflexes; ?></strong>
                                        <br/><strong>Intuition : <?= $fiche_personnage->intuition; ?></strong>
                                    </div>
                                </div>

                                <div class="row text-center">

                                    <div class="col-4 offset-1">
                                        <span class="display-4"><?= min($fiche_personnage->force, $fiche_personnage->perception); ?></span>
                                        <br/>Anneau de l'Eau
                                        <br/><strong>Force : <?= $fiche_personnage->force; ?></strong>
                                        <br/><strong>Perception : <?= $fiche_personnage->perception; ?></strong>
                                    </div>

                                    <div class="col-2">
                                        <img class="img-fluid" src="<?= url_img('5rings.png'); ?>" alt="La 5 anneaux" />
                                    </div>

                                    <div class="col-4">
                                        <span class="display-4"><?= min($fiche_personnage->agilite, $fiche_personnage->intelligence); ?></span>
                                        <br/>Anneau du Feu :
                                        <br/><strong>Agilité : <?= $fiche_personnage->agilite; ?></strong>
                                        <br/><strong>Intelligence : <?= $fiche_personnage->intelligence; ?></strong>
                                    </div>

                                </div>

                                <div class="row text-center">
                                    <div class="offset-4 col-4">
                                        <span class="display-4"><?= $fiche_personnage->vide; ?></span>
                                        <br/>Anneau du Vide
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-primary text-center" role="alert">
                                    <span>Désolé, toutes les statistiques pour cette fiche ne sont pas encore complétées !</span>
                                </div>                         
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
                <div class="col-4">
                    <img class="img-fluid" src="<?= url_img($personnage_trouve->illustration); ?>" />
                </div>
                <div class="col-8">
                    <hr>
                    <div class="row">
                        <?php if(!empty($fiche_personnage)): ?>
                            <div class="col-6">
                                Avantages :<br/>
                                <strong><?= $fiche_personnage->avantages; ?></strong><br/><br/>
                            </div>
                            <div class="col-6">
                                Desavantages :<br/>
                                <strong><?= $fiche_personnage->desavantages; ?></strong><br/><br/>
                            </div>
                        <?php endif; ?>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Compétence</th>
                                <th scope="col">Rang</th>
                                <th scope="col">Trait</th>
                                <th scope="col">Spé.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Armes Lourdes</th>
                                <td>X</td>
                                <td>AGI</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <th scope="row">Art de la Guerre</th>
                                <td>X</td>
                                <td>PERC</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Défense</th>
                                <td>X</td>
                                <td>REFL</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Athlétisme</th>
                                <td>X</td>
                                <td>AGI/FOR</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Etiquette</th>
                                <td>X</td>
                                <td>INTUI</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Statistique de Combat</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Initiative : <strong>XgX</strong></li>
                            <li class="list-group-item">Arme (X) : <strong>XgX</strong></li>
                            <li class="list-group-item">Armure (X) : <strong>+10 ND +5 Réduction</strong></li>
                            <li class="list-group-item">ND d'Armure : <strong>X</strong></li>
                            <li class="list-group-item">Réduction d'Armure : <strong>X</strong></li>
                        </ul>
                        <?php if(!empty($fiche_personnage)): ?>
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Etat</th>
                                        <th>Malus</th>
                                        <th>HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>0</td>
                                        <td><?= 5*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>0</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>+3</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>+5</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>+10</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>+15</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Indemne</td>
                                        <td>+20</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hors de Combat</td>
                                        <td>+30</td>
                                        <td><?= 2*min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Inventaire</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Item 1</li>
                            <li class="list-group-item">Item 2</li>
                            <li class="list-group-item">Item 3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </section>
</main>     
<?php include_once DOSSIER_SCRIPTS . '/scripts.js.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid">
    <section class="container">

        <article class="card">
            <div class="row">
                <div class="col-4">
                    <ul>
                        <li>Nom & Prénom : <strong><?= $personnage_trouve->nom; ?></strong> <strong><?= $personnage_trouve->prenom; ?></strong></li>
                        <li>Clan : <strong><?= $personnage_clan->nom; ?></strong></li>
                        <li>Ecole : <strong><?= $personnage_ecole->nom; ?></strong></li>
                        <li>Joueur : <strong><?= $personnage_utilisateur->prenom; ?></li>
                    </ul>
                </div>
                <div class="col-4">
                    <ul>
                        <li>Rang :</li>
                        <li>Points d'Experience :</li>
                        <li>Reste :</li>
                        <li>Réputation :</li>
                    </ul>
                </div>
                <div class="col-4">
                    <img src="<?= url_img($personnage_trouve->illustration); ?>" />
                </div>
            </div>
        </article>

        <h1><?= $personnage_trouve->nom; ?> <?= $personnage_trouve->prenom; ?></h1>

        XP Création :<br/>
        <strong><?= $fiche_personnage->xp_creation; ?>xp</strong><br/><br/>

        Avantages :<br/>
        <strong><?= $fiche_personnage->avantages; ?></strong><br/><br/>

        Desavantages :<br/>
        <strong><?= $fiche_personnage->desavantages; ?></strong><br/><br/>

        <section class="row">
            <div class="col-4 offset-2">
                Anneau de Terre :
                <span class="display-4"><?= min($fiche_personnage->constitution, $fiche_personnage->volonte); ?></span><br/>
                <ul>
                    <li><strong>Constitution : <?= $fiche_personnage->constitution; ?></strong></li>
                    <li><strong>Volonté : <?= $fiche_personnage->volonte; ?></strong></li>
                </ul>
            </div>
            <div class="col-4">
                Anneau de l'Air :
                <span class="display-4"><?= min($fiche_personnage->reflexes, $fiche_personnage->intuition); ?></span><br/>
                <ul>
                    <li><strong>Relfexes : <?= $fiche_personnage->reflexes; ?></strong></li>
                    <li><strong>Intuition : <?= $fiche_personnage->intuition; ?></strong></li>
                </ul>
            </div>
            <div class="col-4">
                Anneau du Feu :
                <span class="display-4"><?= min($fiche_personnage->agilite, $fiche_personnage->intelligence); ?></span><br/>
                <ul>
                    <li><strong>Agilité : <?= $fiche_personnage->agilite; ?></strong></li>
                    <li><strong>Intelligence : <?= $fiche_personnage->intelligence; ?></strong></li>
                </ul>
            </div>
            <div class="col-4">
            </div>
            <div class="col-4">
                Anneau de l'Eau :
                <span class="display-4"><?= min($fiche_personnage->force, $fiche_personnage->perception); ?></span><br/>
                <ul>
                    <li><strong>Force : <?= $fiche_personnage->force; ?></strong></li>
                    <li><strong>Perception : <?= $fiche_personnage->perception; ?></strong></li>
                </ul>
            </div>
        </section>


        Anneau du Vide :<br/>
        <strong><?= $fiche_personnage->vide; ?></strong>

    </section>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<main class="container-fluid bg-light">
    <div class="container">
        <h1 class="pt-5 mb-5">Bienvenue sur votre espace de compte, <strong><?= $utilisateur_trouve->prenom ?></strong></h1>

        <div class="row mx-3">
            <div class="col-6">
                <h2 class="mb-4">Informations Personnelles</h2>

                <section class="ml-3">
                    Votre Avatar :<br/>
                    <strong class="ml-3"><?= $utilisateur_trouve->image; ?></strong><br/><br/>

                    Votre Identifiant :<br/>
                    <strong class="ml-3"><?= $utilisateur_trouve->identifiant; ?></strong><br/><br/>

                    Votre Adresse Email :<br/>
                    <strong class="ml-3"><?= $utilisateur_trouve->email; ?></strong><br/><br/>

                    Votre Prenom :<br/>
                    <strong class="ml-3"><?= $utilisateur_trouve->prenom; ?></strong><br/><br/>

                    <a href="#">Changer votre mot de passe</a><br/><br/>

                    Votre Rôle :<br/>
                    <strong class="ml-3"><?= $utilisateur_trouve->role; ?></strong><br/><br/>
                </section>
                
            </div>
            <div class="col-6">
                <h2 class="mb-4">Mes Personnages</h2>

                <section class="row ml-3">
                    <?php if(!empty($personnages_utilisateur)): ?>
                        <?php foreach($personnages_utilisateur as $un_personnage): ?>
                            <article class="col-6 mb-3">
                                <div class="card text-left">
                                    <a href="<?= route('profil-personnage&id=' . $un_personnage->id); ?>"><img class="card-img-top survol" src="<?= url_img($un_personnage->icone); ?>" alt="Image du personnage"></a>
                                    <div class="card-body">
                                        <h4 class="card-title"><?= $un_personnage->nom; ?> <strong><?= $un_personnage->prenom; ?></strong></h4>
                                        <p class="card-text text-center">
                                            <i class="fas fa-eye"></i>&nbsp;&nbsp;<a href="<?= route('profil-personnage&id=' . $un_personnage->id); ?>">Profil Public</a><br/>
                                            <i class="fas fa-user-secret"></i>&nbsp;&nbsp;<a href="<?= route('fiche-personnage&id=' . $un_personnage->id); ?>">Fiche Privée</a>

                                        </p>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        Vous n'avez pas encore de personnages !
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
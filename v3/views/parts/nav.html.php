<!-- NAV -->
<?php if (admin_connecte()) : ?>
    <div class="container-fluid bg-secondary text-right">
        <a href="<?= route('administration'); ?>" class="admin">&rarr; Panneau d'Administration</a>
    </div>
<?php endif; ?>
<nav class="container-fluid bg-dark">
    <div class="container">

        <div class="navbar navbar-expand-lg navbar-dark bg-dark bg-primary">
            <div id="logo">
                <a class="navbar-brand" href="<?= route('accueil'); ?>">
                    <img src="<?= url_img('logo-axl.png'); ?>" alt="Logo" class="img-fluid" />
                </a>
            </div>
            <button class="navbar-toggler btn-primary" type="button" data-toggle="collapse"
                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <ul class="navbar-nav">
                        <li class="nav-item <?php if($_GET['page'] == 'aventure' || $_GET['page'] == 'episode') echo 'active'; ?>">
                            <a class="nav-link" href="<?= route('aventure'); ?>">AVENTURE</a>
                        </li>
                        <li class="nav-item <?php if($_GET['page'] == 'personnages') echo 'active'; ?>">
                            <a class="nav-link" href="<?= route('personnages'); ?>">PERSONNAGES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="<?= route('empire'); ?>">EMPIRE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="<?= route('regles'); ?>">REGLES</a>
                        </li>
                    </ul>
                    <?php if (!utilisateur_connecte()): ?>
                        <button type="button" class="btn btn-primary nav-item" data-toggle="modal" data-target="#connexion">Se Connecter</button>
                    <?php else: ?>
                        <div class="row">
                            <div class="text-right text-light">Bon retour,<br/><strong><?= $_SESSION['prenom']; ?></strong><br/>
                                <a href="<?= route('se-deconnecter'); ?>"><button type="button" class="btn btn-primary nav-item">Se Deconnecter</button></a>
                            </div>
                            <div><img src="<?= $_SESSION['image']; ?>" alt="" style="width: 84px; margin-left: 10px;"/></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
</nav>
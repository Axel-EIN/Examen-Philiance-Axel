<?php if(!admin_connecte()) redirection('403', 'Accès non-autorisé !'); ?>
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

</main>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
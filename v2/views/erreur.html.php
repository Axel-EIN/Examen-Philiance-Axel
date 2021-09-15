<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<div class="container text-center">
    <h1><?= $h1; ?></h1>
    
    <p><?= $message_erreur; ?></p>
</div>

<?php if(!utilisateur_connecte()): ?>
    <?php include_once DOSSIER_VIEWS . '/parts/modal.html.php'; ?>
<?php endif; ?>
<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>
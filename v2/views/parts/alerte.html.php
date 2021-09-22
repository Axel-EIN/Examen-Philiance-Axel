<!-- ALERTE -->
<?php if(!empty($_GET['alerte'])): ?>

    <?php if(empty($_GET['type'])) $type_alerte = 'primary'; else $type_alerte = $_GET['type']; ?>

    <div class="row">
        <div class="alert alert-<?= $type_alerte; ?> alert-dismissible fade show mx-auto" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Fermer</span>
            </button>

            <?php if ($type_alerte == 'danger'): ?>
                <strong>Attention!</strong>
            <?php elseif ($type_alerte == 'success'): ?>
                <strong>Opération réussie!</strong>
            <?php else: ?>
                <strong>Notification:</strong>
            <?php endif; ?>

            <?= $_GET['alerte']; ?>
        </div>
    </div>

<?php endif; ?>
<!-- FIN : ALERTE -->
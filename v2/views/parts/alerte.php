<!-- ALERTE -->
<?php if(!empty($_GET['alerte'])): ?>
    <?php if(empty($_GET['type_alerte'])) $type_alerte = 'success';
          else $type_alerte = $_GET['type_alerte']; ?>
    <div class="row">
        <div class="alert alert-<?= $type_alerte; ?> alert-dismissible fade show mx-auto" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <?php if ($type_alerte == 'danger'): ?>
                <strong>Attention!</strong>
            <?php else: ?>
                <strong>Opération réussie!</strong>
            <?php endif; ?>
            <?= $_GET['alerte']; ?>
        </div>
    </div>
<?php endif; ?>
<!-- FIN : ALERTE -->
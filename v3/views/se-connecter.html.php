<?php include_once DOSSIER_VIEWS . '/parts/header.html.php'; ?>

<section class="container">

  <div class="row">
    <div class="col-10 offset-1">
      <h1 class="my-5"><?= $h1; ?></h1>
    </div>
  </div>

  <?php if (!empty($_GET['alerte'])): ?>
    <div class="row">
      <div class="col-8 offset-2">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Attention!</strong> <?= $_GET['alerte']; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-8 offset-2">
      <?php include DOSSIER_VIEWS . '/parts/form-se-connecter.html.php'; ?>
    </div>
  </div>
</section>

<?php include_once DOSSIER_VIEWS . '/parts/footer.html.php'; ?>

<!-- ADMIN - NAV -->
<?php if (admin_connecte()) : ?>
    <nav class="nav justify-content-center">
        <a  class="nav-link <?php if (!empty($_GET['page']) && $_GET['page'] == 'administration'): ?>active<?php endif; ?>"
            href="<?= route('administration'); ?>">Scènes</a>

        <a  class="nav-link <?php if (!empty($_GET['page']) && $_GET['page'] == 'administration-episodes'): ?>active<?php endif; ?>"
            href="<?= route('administration-episodes'); ?>">Episodes</a>

        <a  class="nav-link <?php if (!empty($_GET['page']) && $_GET['page'] == 'administration-chapitres'): ?>active<?php endif; ?>"
            href="<?= route('administration-chapitres'); ?>">Chapitres</a>

        <a  class="nav-link  <?php if (!empty($_GET['page']) && $_GET['page'] == 'administration-saisons'): ?>active<?php endif; ?> disabled"
            href="<?= route('administration-saisons'); ?>">Saisons</a>
    </nav>
<?php endif; ?>
<!-- /ADMIN - NAV -->
<?php if(admin_connecte()): $numero = 1; ?>
    <div class="d-flex justify-content-center">
        <div class="col-3 text-center p-2">
            <a href="<?= route('admin-creer-scene&id_episode=' . $episode_trouve->id . '&numero=' . $numero); ?>">
                <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Insérer une scène ici
            </a>
        </div>
    </div>
<?php endif; ?>
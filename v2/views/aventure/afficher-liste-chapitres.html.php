<!-- AFFICHAGE DES CHAPITRES DE LA SAISON -->
<main>
    <div id="liste-ch" class="pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="display-4 text-center pb-3">Liste des Chapitres</h2>
                </div>
            </div>
        </div>
    </div>
    <?php
        foreach ($chapitres as $chapitre)
            afficher_un_chapitre($chapitre);
    ?>
</main>
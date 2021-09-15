<!-- FOOTER -->
<footer>
    <div class="container-fluid bg-footer1 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-2 text-white">
                    <h5>Plan du site</h5>
                    <nav>
                        <ul>
                            <li><a class="footer-link" href="<?= route('aventure'); ?>">L'Aventure</a></li>
                            <li><a class="footer-link" href="<?= route('empire'); ?>">L'Empire</a></li>
                            <li><a class="footer-link" href="<?= route('regles'); ?>">Les Règles</a></li>
                            <li><a class="footer-link" href="<?= route('se-connecter'); ?>">Se Connecter</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-2 offset-8 text-white">
                    <h5>Réseaux Sociaux</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-footer2 pt-4">
        <div class="row justify-content-center">
            <div class="col-12 text-center text-white align-middle">
                &copy;&nbsp;Site réalisé par Axel Onçu pour l'examen final de Philiance
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/9f0d0d61c1.js" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
                integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" href="style2.css" />
    </head>
        
    <body>

    <nav class="container-fluid" style="background-color: rgba(0,0,0,0.4);">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center w-100">

                <div id="logo">
                    <a class="navbar-brand" href="#"><img src="#" alt="Logo" class="img-fluid" /></a>
                </div>

                <div class="navbar navbar-expand-lg navbar-dark">
                    <button class="navbar-toggler btn-primary" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Amérique du Nord</strong></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Amérique du Sud</strong></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Europe</strong></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Afrique</strong></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Asie</strong></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><strong>Océanie</strong></a></li>
                        </ul>
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary nav-item" data-toggle="modal" data-target="#connexion">Se Connecter</button>

            </div>
            
        </div>
    </nav>

    <div class="container">

        <header class="pt-4 px-3" style="min-height: 40vh;">

            <div class="card">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12" style="min-height: 340px; background-image: url('https://via.placeholder.com/960x540');" >
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="p-5">
                            <h1>Les Tapas du Soleil !</h1>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis harum hic alias deserunt nobis esse rerum praesentium aut magnam provident?</p>

                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis harum hic alias deserunt nobis esse rerum praesentium aut magnam provident?</p>
                            <div class="text-center">
                                <button class="btn btn-primary">Découvrir !</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </header>

        <!-- CARTE IMAGE MENUE -->
        <section class="pt-4 px-3" style="min-height: 40vh;">
            <div id="bandeau-menu" style="min-height: 340px">

            </div>
        </section>

        <!-- 3 CARDS -->
        <section class="row pt-3 pb-3">

            <div class="col-lg-4 col-md-6 col-sm-12 px-4">
                <div class="card">
                    <img src="https://via.placeholder.com/960x540" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Title</h4>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <a href="#">Voir l'article</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 px-4">
                <div class="card">
                    <img src="https://via.placeholder.com/960x540" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Title</h4>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <a href="#">Voir l'article</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 px-4">
                <div class="card">
                    <img src="https://via.placeholder.com/960x540" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Title</h4>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis modi, praesentium vitae dolor corporis?</p>
                        <a href="#">Voir l'article</a>
                    </div>
                </div>
            </div>

        </section>

    </div>

        


    <footer class="container-fluid bg-dark py-3 mt-5">
        <div class="container text-light">
            <ul>
                <li>Lien1</li>
                <li>Lien2</li>
                <li>Lien3</li>
            </ul>
        </div>
    </footer>

    </body>
</html>
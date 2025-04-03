<?php 
session_start();
if(!isset($_SESSION["cliente"])){
    $_SESSION["cliente"]="";
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Peliculón</title>
    <style>
        body {
            background-color: #000;
            color: #FFF;
        }

        .navbar {
            background-color: #941010fe;
        }

        .navbar a {
            color: #FFF;
            text-decoration: none;
            margin: 0 20px;
        }

        .container {
            padding: 20px;
        }

        h1 {
            font-size: 36px;
            color: #ffffff;
        }

        .content {
            background-color: #000;
            color: #FFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .content img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
        }

        .reviews {
            text-align: center;
        }

        .review-item {
            background-color: #333;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
        }

        .review-title {
            font-size: 24px;
            color: #FFF;
        }

        .star-icon {
            color: #FFD700;
        }

        .footer {
            background-color: #941010fe;
            color: #FFF;
            text-align: center;
            padding: 20px;
            height: 150px;
        }

        .login-form {
            background-color: #333;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #444;
            color: #FFF;
            border-radius: 5px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #941010fe;
            color: #FFF;
            border-radius: 5px;
        }

        .catalog-item {
            background-color: #1c1c1c; 
            margin: 10px;
            border-radius: 10px;
        }

        .catalog-title {
            font-size: 20px; 
            color: #FFF;
        }

        .catalog-description {
            font-size: 16px; 
            color: #BBB; 
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="homepagecli.php">
                    <h1>Peliculón</h1>
                </a>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                    <a href="inicio de sesion.php">
                        <?php
             if($_SESSION["cliente"]!=""){
                echo'
                <li><a href="logout.php" class="cart-icon">Cerrar Sesion</a></li>';
                }
                else{
                }
                ?>
                       <?php
             if($_SESSION["cliente"]!=""){
                echo'
                <a href="catalogocli.php" class="cart-icon">Catalogo</a></li>';
                }
                else{
                    echo'
                <a href="catalogo.php" class="cart-icon">Catalogo</a></li>';
                
                }
            
                ?>
                        <button class="btn btn-outline-secondary ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                         </svg> Carrito
                        </button>
                            </div>


                          

                    
                </div>

            </div>
        </nav>
    </header>
    
    <main class="container mt-4">
        <div class="content">
            <img src="Publicidad.jpg" alt="Publicidad" class="img-fluid">
        </div>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="catalog-item">
                    <img src="imagenes/Artery.jpg" alt="Arttiety y el mundo de los diminutos" class="img-fluid">
                    <h2 class="catalog-title">Arrietty y el mundo de los diminutos</h2>
                    <p class="catalog-description">Arrietty, una pequeña joven, vive con sus padres en una casa de los suburbios...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="catalog-item">
                    <img src="imagenes/Kiki.jpg" alt="Kiki Servicios a Domicilio" class="img-fluid">
                    <h2 class="catalog-title">Kiki Servicios a Domicilio</h2>
                    <p class="catalog-description">Al cumplir los 13 años, la brujita Kiki debe, como manda la tradición...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="catalog-item">
                    <img src="imagenes/Chihiro.jpg" alt="El viaje de Chihiro" class="img-fluid">
                    <h2 class="catalog-title">El viaje de Chihiro</h2>
                    <p class="catalog-description">Chihiro es una niña caprichosa que debe adentrarse en un mundo de fantasía...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="catalog-item">
                    <img src="imagenes/mononoke.jpg" alt="La Princesa Mononoke" class="img-fluid">
                    <h2 class="catalog-title">La Princesa Mononoke</h2>
                    <p class="catalog-description">Un príncipe se ve involucrado en un conflicto entre una princesa del bosque...</p>
                </div>
            </div>
        </div>
        <div class="reviews">
            <div class="row">
                <div class="col-md-4">
                    <div class="review-item">
                        <img src="imagenes/Luciernagas.jpg" alt="Tumba de las Luciernagas" class="img-fluid">
                        <h2 class="review-title">Reseñas</h2>
                        <p>Es una película bastante triste y con un final conmovedor</p>
                        <p class="star-icon">★ ★ ★ ★ ☆ (50 reseñas)</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-item">
                        <img src="imagenes/Totoro.jpg" alt="Mi vecino Totoro" class="img-fluid">
                        <h2 class="review-title">Reseña</h2>
                        <p>Es una película para todo tipo de público, la película me encanta</p>
                        <p class="star-icon">★ ★ ★ ★ ★ (20 reseñas)</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-item">
                        <img src="imagenes/perfect blue.jpg" alt="Perfect Blue" class="img-fluid">
                        <h2 class="review-title">Es una película bastante confusa y con un final que desear pero la animación es buena</h2>
                        <p>Reseña de la película 3.</p>
                        <p class="star-icon">★ ★ ★ ☆ ☆ (10 reseñas)</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        &copy; 2023 Peliculón. Todos los derechos reservados.
    </footer>
</body>
</html>
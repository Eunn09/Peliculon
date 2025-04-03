<?php

include 'connection.php';



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sb-admin-2.min.css">
    <link rel="stylesheet" href="sb-admin-2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        /* Estilos para el catálogo de muestra */
        .catalog-item {
            background-color: #1c1c1c; /* Fondo gris oscuro */
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
        }

        .catalog-title {
            font-size: 20px; /* Tamaño de fuente más pequeño */
            color: #FFF;
        }

        .catalog-description {
            font-size: 16px; /* Tamaño de fuente de la descripción */
            color: #BBB; /* Color de texto gris */
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-dark">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="homapage.php">
                    <h1>Peliculón</h1>
                </a>
                <div class="d-flex">
                    <a href="inicio de sesion.php">Iniciar Sesión</a>
                    <a href="Registrarse.php">Registrarse</a>
                    <a href="catalogo.php">Catálogo</a>
                </div>
            </div>
        </nav>
    </header>

    <body style="background-color: black;">

        <!-- Título de la página -->
        <h1 class="tit">Catálogo de Películas</h1>
        <div class="text-center">
                     <select class="form-select btn btn-secondary btn-user btn-block" id="exampleSelect1" onchange="redirigir(this)">
                     <option value=#>Eliga catalogo</option>
                     <option value="catalogocli.php">Sucursal Queretaro</option>
                     <option value="catalogocdmx.php">Sucursal CDMX</option>
                     <option value="catalogoc.php">Sucursal Cuernavaca</option>
                     </select>
        </div>
        <div class="container-fluid">
            <!-- Contenido de la sección fluida -->
        </div>

        <!-- Sección de productos -->
        <div class="col py-4">
            <section class="products-section">
            <?php
                                     $selectpeli=mysqli_query($conexion,"SELECT * FROM pelicula") or die('query failed');
                                     if(mysqli_num_rows($selectpeli)>0){
                                        while($fetch_product=mysqli_fetch_assoc($selectpeli)){
                                        
                                ?>

                        <div class="product-card">
                        <img src="imagenes/<?php echo $fetch_product['img_peli'];?>" alt="">
                        <div><p><?php echo $fetch_product['tit_peli'];?></p></div>
                        <div><p><?php echo $fetch_product['costo_peli'];?></p></div>
                        <div><p><?php echo $fetch_product['anio_peli'];?></p></div>
                        <a href="carrito.php" class="btn">Comprar</a>
                        </div>
                        <?php
                        };
                        };
                        ?>
                                         
            </section>
        </div>

        <!-- Pie de página -->
        <footer class="footer">
            &copy; 2023 Peliculón. Todos los derechos reservados.
        </footer>
    </body>
</html>

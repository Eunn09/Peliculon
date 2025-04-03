<?php
session_start();
if(isset($_SESSION["cliente"]) && $_SESSION["cliente"] === true){
    // El usuario es un cliente, se permite el acceso a la página

    ini_set('display_errors', 'on');
error_reporting(E_ALL);
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "toto_jk9514Th99";
$database = "peliculon";

// Crear una conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $database);
    // Coloca aquí el contenido de la página para el cliente
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sb-admin-2.min.css">
    <link rel="stylesheet" href="sb-admin-2.css">
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

        .catalog-item {
            background-color: #1c1c1c; 
            padding: 20px;
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
                <div class="d-flex">
                    <a href="homepagecli.php">Home</a>
                    <a href="catalogocli.php">Catálogo</a>
                    <a href="carrito.php">Carrito</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1 class="tit">Catálogo de Películas</h1>
        <div class="text-center">
            <label for="filtro">Filtrar por Categoría:</label>
            <select id="filtro" class="form-select">
                <option value="todos">Todos</option>
                <?php
                $select_sucursal = "SELECT * FROM sucursal";
                $execute_sql = mysqli_query($conn, $select_sucursal);
                while ($row = mysqli_fetch_array($execute_sql)) {
                ?>
                    <option value="<?php echo $row["id_suc"]; ?>"><?php echo $row["nom_suc"]; ?></option>
                <?php } ?>
            </select>
        </div>
        <section id="shoping-catalog" class="container mt-5 mb-5">

            <?php
            $execute_sql = mysqli_query($conn, $select_sucursal);
            while ($row_sucursal = mysqli_fetch_array($execute_sql)) {
                $id_suc = $row_sucursal["id_suc"];
            ?>
                <section class="<?php echo $row_sucursal["id_suc"]; ?> productos">
                    <h1 class="fs-4 my-3"><?php echo $row_sucursal["nom_suc"]; ?></h1>
                    <div class="row g-4">
                        <?php
                        $select_productos_sucursal = "SELECT inventario.*, pelicula.*, sucursal.* FROM inventario INNER JOIN pelicula ON inventario.id_peli = pelicula.id_peli INNER JOIN sucursal ON inventario.id_suc = sucursal.id_suc WHERE sucursal.id_suc = '$id_suc' and inventario.exist_inv > 0";

                        $execute_sql_productos = mysqli_query($conn, $select_productos_sucursal);
                        while ($row_articles = mysqli_fetch_array($execute_sql_productos)) {
                        ?>
                            <div class="col py-4">
                                <section class="products-section">
                                    <div class="product-card catalog-item">
                                        <img src="imagenes/<?php echo $row_articles['img_peli']; ?>" alt="" class="img-fluid">
                                        <div><p class="catalog-title"><?php echo $row_articles['tit_peli']; ?></p></div>
                                        <div><p><?php echo $row_articles['costo_peli']; ?></p></div>
                                        <div><p><?php echo $row_articles['anio_peli']; ?></p></div>
                                        <div><p>Stock:<?php echo $row_articles['exist_inv']; ?></p></div>
                                        <!-- Agrega el formulario para la cantidad y el botón de comprar -->
                                        <form action="carrito.php" method="post">
                                            <input type="hidden" name="id_inv" value="<?php echo $row_articles['id_inv']; ?>">
                                            <input type="hidden" name="tit_peli" value="<?php echo $row_articles['tit_peli']; ?>">
                                            <input type="hidden" name="costo_peli" value="<?php echo $row_articles['costo_peli']; ?>">
                                            <input type="hidden" name="exist_inv" value="<?php echo $row_articles['exist_inv']; ?>">
                                            <button type="submit" class="btn btn-danger">Comprar</button>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>
        </section>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#filtro").change(function() {
                    var selectedCategory = $(this).val();
                    if (selectedCategory === "todos") {
                        $(".productos").show();
                    } else {
                        $(".productos").hide();
                        $("." + selectedCategory).show();
                    }
                });
            });
        </script>

    </div>
    <footer class="footer">
        &copy; 2023 Peliculón. Todos los derechos reservados.
    </footer>
</body>

</html>

<?php
} else {
    // Si no es un cliente, redirige a la página de inicio de sesión o a alguna otra página de acceso
    header("Location: inicio de sesion.php");
    exit ;
// Cierra la conexión a la base de datos
mysqli_close($conn);
}
?>
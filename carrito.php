<?php
session_start();
if(isset($_SESSION["cliente"]) && $_SESSION["cliente"] === true){

$servername = "localhost";
$username = "root";
$password = "toto_jk9514Th99";
$database = "peliculon";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function obtenerInformacionProducto($id_inv) {
    global $conn;

    $query = "SELECT pelicula.tit_peli, pelicula.costo_peli, pelicula.img_peli FROM inventario
              INNER JOIN pelicula ON inventario.id_peli = pelicula.id_peli
              WHERE inventario.id_inv = '$id_inv'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return array(
            'nombre' => $row['tit_peli'],
            'precio' => $row['costo_peli'],
        );
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        return null;
    }
}


function obtenerStockDisponible($id_inv) {
    global $conn;

    $query = "SELECT exist_inv FROM inventario WHERE id_inv = '$id_inv'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['exist_inv'];
    } else {
        return 0;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_inv"])) {
        if (isset($_POST["id_inv"])) {
            $inventario_seleccionado = $_POST["id_inv"];
            
            $nueva_cantidad = $_POST["cantidad_" . $inventario_seleccionado];
        
        // Obtener el stock disponible del inventario
        $stock_disponible = obtenerStockDisponible($inventario_seleccionado);
        
        // Verificar si la cantidad en el carrito más la nueva cantidad supera el stock disponible
        if ($_SESSION['carrito'][$inventario_seleccionado]['cantidad'] + $nueva_cantidad > $stock_disponible) {
            // Manejar el error cuando se supera el stock disponible
            echo "No se puede agregar más cantidad de este producto. Supera el stock disponible.";
            // Otras acciones o mensajes de error que desees mostrar
        } else {
            // Actualizar la cantidad en el carrito si no excede el stock
            $_SESSION['carrito'][$inventario_seleccionado]['cantidad'] = $nueva_cantidad;
        }
    }

}
}

// Función para obtener el stock disponible de un producto en el inventari
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
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
            color: #FFF;
        }

        .card {
            background-color: #1c1c1c;
            border-radius: 10px;
            margin: 10px;
        }

        .card-body {
            padding: 20px;
        }

        .form-label,
        .card-text,
        .form-control,
        label {
            color: #FFF;
        }

        .btn-primary {
            background-color: #941010fe;
            color: #FFF;
            border-radius: 5px;
        }

        .btn-danger {
            background-color: #941010fe;
            color: #FFF;
            border-radius: 5px;
        }

        .mt-3 {
            margin-top: 3%;
        }

        .container.mt-5 {
            margin-top: 5%;
        }

        .btn-primary {
            background-color: #941010;
            color: #FFF;
            border-radius: 5px;
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
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h2>Detalles del Producto</h2>
        <section id="shoping-catalog" class="container mt-5 mb-5">
            <?php
           
$subtotal = 0;
$contadorProductos = 1;

foreach ($_SESSION['carrito'] as $inventario_id => $detalle) {
    $producto_info = obtenerInformacionProducto($inventario_id);

    if ($producto_info) {
        $nombre_producto = $producto_info['nombre'];
        $precio_producto = $producto_info['precio'];
        $cantidad_producto = $detalle['cantidad'];

        $subtotal_producto = $precio_producto * $cantidad_producto;
        $_SESSION['total'] = $subtotal_producto;
        $subtotal += $subtotal_producto;



        ?>
        <div class="card my-3">
            <div class="card-body">
                <p class="card-text">Número de Producto: <?php echo $contadorProductos; ?></p>
                <p class="card-text">Nombre del producto: <?php echo $nombre_producto; ?></p>
                <p class="card-text">Precio por unidad: $<?php echo $precio_producto; ?></p>
                <p class="card-text">Cantidad en el carrito: <?php echo $cantidad_producto; ?></p>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="number" name="id_inv" value="<?php echo $inventario_id; ?>" style="display: none;">
                    <label for="cantidad_<?php echo $inventario_id; ?>">Cantidad:</label>
                    <input type="number" name="cantidad_<?php echo $inventario_id; ?>" value="<?php echo $cantidad_producto; ?> " min="1">
                    <button type="submit" class="btn btn-danger">Actualizar Carrito</button>
                </form>
            </div>
        </div>
        <?php
        

        $contadorProductos++;
    }
}
?>
<div class="mt-3">
    <?php
    $subtotal_sin_iva = $subtotal / 1.16;
    $iva = $subtotal - $subtotal_sin_iva;
    $total_final = $subtotal_sin_iva + $iva;
    
    $productos_en_carrito = false;
    foreach ($_SESSION['carrito'] as $inventario_id => $detalle) {
        $cantidad_producto = $detalle['cantidad'];

        if ($cantidad_producto > 0) {
            // Si hay al menos un producto con una cantidad mayor que cero, establecer la bandera en verdadero
            $productos_en_carrito = true;
            break; // Salir del bucle ya que encontramos un producto con cantidad mayor que cero
        }
    }

    ?>

    <p>Subtotal del carrito (sin IVA): $<?php echo number_format($subtotal_sin_iva, 2); ?></p>
    <p>Total IVA: $<?php echo number_format($iva, 2); ?></p>
    <p>Total Final: $<?php echo number_format($total_final, 2); ?></p>

    <!-- Cambios en el botón de comprar -->
    <?php
    if ($productos_en_carrito) {
        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comprarModal">
            Comprar
        </button>';
    }
    ?>

    <!-- Modal de Compra -->
    <div class="modal fade" id="comprarModal" tabindex="-1" role="dialog" aria-labelledby="comprarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="background-color: #1c1c1c; color: #FFF;">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="facturaCheckbox" name="facturaCheckbox" style="color: #FFF;">
                            <label class="form-check-label" for="facturaCheckbox" style="color: #FFF;">Deseo factura</label>
                        </div>


                        <script>
                         // Obtener el elemento del checkbox
                        const facturaCheckbox = document.getElementById('facturaCheckbox');

                            // Agregar un evento al cambio del checkbox
                            facturaCheckbox.addEventListener('change', function() {
                            // Verificar si el checkbox está seleccionado
                            if (this.checked) {
                            // Redirigir a la página deseada cuando el checkbox está seleccionado
                            window.location.href = 'datos_fac.php';
                            }
                            });
                            </script>

                        <!-- Campos ocultos para enviar información necesaria -->
                        <input type="hidden" name="subtotal_sin_iva" value="<?php echo $subtotal_sin_iva; ?>">
                        <input type="hidden" name="iva" value="<?php echo $iva; ?>">
                        <input type="hidden" name="total_final" value="<?php echo $total_final; ?>">

                        <button  id="boton-comprar" type="submit" class="btn btn-danger">Confirmar Compra
                        </button>
                        <script>
    // Obtener el botón de compra por su ID
    const botonComprar = document.getElementById('boton-comprar');

    // Agregar un evento de clic al botón
    botonComprar.addEventListener('click', function() {
        // Redirigir a otra_pagina.php cuando se haga clic en el botón
        window.location.href = 'pago.php';
    });
    </script>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="vaciar carrito.php" class="btn btn-danger">Vaciar Carrito</a>
</div>

<script>
    // Mostrar u ocultar el formulario de factura según el estado del checkbox
    $(document).ready(function () {
        $('#facturaCheckbox').change(function () {
            $('#facturaForm').toggle(this.checked);
        });
    });
</script>


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


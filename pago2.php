<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información del Cliente</title>
    <!-- Agrega los enlaces a los archivos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    <div class="container mt-5">
        <?php
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "toto_jk9514Th99";
        $dbname = "peliculon";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verificar si el usuario está autenticado y tiene un ID de usuario en la sesión
        if (isset($_SESSION['id_cli'])) {
            $id_usuario = $_SESSION['id_cli'];

            // Obtener los datos del cliente a través de la relación con usuario
            $sql_cliente = "SELECT * FROM cliente WHERE id_cli = $id_usuario";
            $result_cliente = $conn->query($sql_cliente);

            if ($result_cliente->num_rows > 0) {
                // Mostrar la dirección del cliente
                $row_cliente = $result_cliente->fetch_assoc();
                $direccion = $row_cliente['col_cli'] . ", " . $row_cliente['calle_cli'] . ", " . $row_cliente['nI_cli'] . ",  " . $row_cliente['nE_cli'] . ", " . $row_cliente['id_mun'] . ", CP: " . $row_cliente['cp_cli'];
                ?>
                <h3>Tu dirección es:</h3>
                <p><?php echo $direccion; ?></p>
                <hr>

                <!-- Formulario de tarjeta de crédito con Bootstrap -->
                <form action="compra.php" method="post" class="mt-4">
                    <div class="form-group">
                        <label for="numero_tarjeta">Número de Tarjeta</label>
                        <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ingresa el número de tarjeta">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha_expiracion">Fecha de Expiración</label>
                            <input type="text" class="form-control" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="codigo_seguridad">Código de Seguridad</label>
                            <input type="text" class="form-control" id="codigo_seguridad" name="codigo_seguridad" placeholder="CVC/CVV">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Procesar Pago</button>
                </form>
                <?php
            } else {
                echo "No se encontraron datos del cliente para este usuario.";
                // Agregar un botón para redirigir a cliente.php
                ?>
                <a href="datos_fac.php" class="btn btn-primary mt-3">Introduce tus datos por favor</a>
                <?php
            }
        } else {
            echo "ID de usuario no encontrado en la sesión.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
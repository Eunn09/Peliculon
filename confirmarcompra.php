<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agrega tus estilos adicionales si los necesitas -->
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
        <h2 class="mb-4">Confirmación de Compra</h2>
        <p>Tu compra se ha procesado correctamente.</p>
        

        <h2 class="mb-4">Genera tu factura aqui</h2>
        <a href="factura.php" class="btn btn-primary" style="background-color: #C40006;">Generar factura</a>
        <!-- Aquí puedes mostrar los detalles de la compra si lo deseas -->

            <div class="form-check">
            </div>

            <br>  <?php
        
            session_start();
            
            $servername = "localhost";
            $username = "root";
            $password = "toto_jk9514Th99";
            $dbname = "peliculon";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            
            // Limpiar el carrito después de procesar la compra
    unset($_SESSION['carrito']);
?>

            <button type="submit" class="btn btn-primary" onclick="redirigirAPagina()">Continuar</button>
            <script>
    function redirigirAPagina() {
        // Redirige a la página deseada
        window.location.href = 'homepagecli.php';
    }
</script>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
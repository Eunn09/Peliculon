<?php
include 'connection.php';

$pelicula = array(); // Inicializa la variable $pelicula

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_peli"])) {
    $id_peli = $_GET["id_peli"];

    // Realiza una consulta para obtener los detalles de la pelicula con el ID proporcionado
    $query = "SELECT * FROM pelicula WHERE id_peli = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_peli);
    $stmt->execute();
    
    // Obtener el resultado
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $pelicula = $result->fetch_assoc();
    } else {
        echo "Pelicula no encontrada.";
        exit; // Si la pelicula no se encontró, salimos del script para evitar más errores.
    }

    $stmt->close(); // Cerrar la sentencia preparada
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peli = $_POST["id_peli"];
    $tit_peli = $_POST["tit_peli"];
    $prec_peli = $_POST["prec_peli"];
    $costo_peli = $_POST["costo_peli"];
    $anio_peli = $_POST["anio_peli"];
    $img_peli = $_POST["img_peli"];
    $id_gen = $_POST["id_gen"];
    
    // Realiza una consulta para actualizar los detalles de la pelicula
    $query = "UPDATE pelicula SET tit_peli = ?, prec_peli = ?, costo_peli = ?, anio_peli = ?, img_peli = ?, id_gen = ? WHERE id_peli = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sddssii", $tit_peli, $prec_peli, $costo_peli, $anio_peli, $img_peli, $id_gen, $id_peli);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Pelicula actualizada con éxito.";

        // Redirige a la página de lista de peliculas después de la actualización
        header('Location: gestpeli.php?success=true');
        exit;
    } else {
        echo "Error al actualizar la pelicula: " . $stmt->error;
    }

    $stmt->close(); // Cerrar la sentencia preparada
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar</title>
    <style>
        /* Estilos generales */
        body {
            background-color: #000;
            color: #FFF;
            margin: 0;
            padding: 0;
        }

        /* Estilos para el encabezado (navbar) */
        .navbar {
            background-color: #941010fe;
        }

        .navbar a {
            color: #FFF;
            text-decoration: none;
            margin: 0 20px;
        }

        /* Estilos para el formulario de registro */
        .form-container {
            background-color: #333;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #444;
            color: #FFF;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #941010fe;
            color: #FFF;
            border-radius: 5px;
        }

        /* Estilos para el pie de página (footer) */
        footer {
            background-color: #941010fe;
            color: #FFF;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Encabezado (navbar) -->
    <header>
        <nav class="navbar navbar-dark">
        </nav>
    </header>
 
    <div class="form-container">
        <h2>Editar pelicula</h2>
        <form action="editpeli.php" method="post">
            <input type="hidden"  name="id_peli" value="<?php echo isset($pelicula['id_peli']) ? $pelicula['id_peli'] : ''; ?>">
            <input type="text"  name="tit_peli"  value="<?php echo isset($pelicula['tit_peli']) ? $pelicula['tit_peli'] : ''; ?>" placeholder="Titulo" required>
            <input type="text" name="prec_peli"  value="<?php echo isset($pelicula['prec_peli']) ? $pelicula['prec_peli'] : ''; ?>" placeholder="Precio" required>
            <input type="text" name="costo_peli" value="<?php echo isset($pelicula['costo_peli']) ? $pelicula['costo_peli'] : ''; ?>" placeholder="Costo" required>
            <input type="text" name="anio_peli"  value="<?php echo isset($pelicula['anio_peli']) ? $pelicula['anio_peli'] : ''; ?>" placeholder="Anio" required>
            <input type="text" name="img_peli" value="<?php echo isset($pelicula['img_peli']) ? $pelicula['img_peli'] : ''; ?>" placeholder="Imagen" required>
            <input type="text" name="id_gen" value="<?php echo isset($pelicula['id_gen']) ? $pelicula['id_gen'] : ''; ?>" placeholder="Genero" required>
            <input type="submit" value="Actualizar">


        
        </form>
    </div>
 
</body>
</html>
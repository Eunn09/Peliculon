<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){


  
include 'connection.php';

$sucursal = array(); // Inicializa la variable $sucursal

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_suc"])) {
    $id_suc = $_GET["id_suc"];

    // Realiza una consulta para obtener los detalles de la sucursal con el ID proporcionado
    $query = "SELECT * FROM sucursal WHERE id_suc = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_suc);
    $stmt->execute();
    
    // Obtener el resultado
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $sucursal = $result->fetch_assoc();
    } else {
        echo "Sucursal no encontrada.";
        exit; // Si la sucursal no se encontró, salimos del script para evitar más errores.
    }

    $stmt->close(); // Cerrar la sentencia preparada
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_suc = $_POST["id_suc"];
    $nom_suc = $_POST["nom_suc"];
    $col_suc = $_POST["col_suc"];
    $call_suc = $_POST["call_suc"];
    $nI_suc = $_POST["nI_suc"];
    $nE_suc = $_POST["nE_suc"];
    $cp_suc = $_POST["cp_suc"];
    $id_mun = $_POST["id_mun"];
    
    // Realiza una consulta para actualizar los detalles de la sucursal
    $query = "UPDATE sucursal SET nom_suc = ?, col_suc = ?, call_suc = ?, nI_suc = ?, nE_suc = ?, cp_suc = ?, id_mun = ? WHERE id_suc = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssisisi", $nom_suc, $col_suc, $call_suc, $nI_suc, $nE_suc, $cp_suc, $id_mun, $id_suc);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Sucursal actualizada con éxito.')</script>";

        // Redirige a la página de lista de sucursales después de la actualización
        header('Location: gestsuc.php?success=true');
        exit;
    } else {
        echo "Error al actualizar la sucursal: " . $stmt->error;
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
        <h2>Editar Sucursal</h2>
        <form action="editsuc.php" method="post">
            <input type="hidden"  name="id_suc" value="<?php echo isset($sucursal['id_suc']) ? $sucursal['id_suc'] : ''; ?>">
            <input type="text"  name="nom_suc" placeholder="Nombre" value="<?php echo isset($sucursal['nom_suc']) ? $sucursal['nom_suc'] : ''; ?>" required>
            <input type="text" name="col_suc" placeholder="Colonia" value="<?php echo isset($sucursal['col_suc']) ? $sucursal['col_suc'] : ''; ?>" required>
            <input type="text" name="call_suc" placeholder="Calle" value="<?php echo isset($sucursal['call_suc']) ? $sucursal['call_suc'] : ''; ?>" required>
            <input type="text" name="nI_suc" placeholder="Numero Interior" value="<?php echo isset($sucursal['nI_suc']) ? $sucursal['nI_suc'] : ''; ?>" required>
            <input type="text" name="nE_suc" placeholder="Numero Exterior" value="<?php echo isset($sucursal['nE_suc']) ? $sucursal['nE_suc'] : ''; ?>" required>
            <input type="text" name="cp_suc" placeholder="Codigo postal" value="<?php echo isset($sucursal['cp_suc']) ? $sucursal['cp_suc'] : ''; ?>" required>
            <input type="text" name="id_mun" placeholder="Municipio" value="<?php echo isset($sucursal['id_mun']) ? $sucursal['id_mun'] : ''; ?>" required>
            <input type="submit" value="Actualizar">


        
        </form>
    </div>
 
</body>
</html>
<?php
}else{
    header("Location: inicio de sesion.php");
    exit;
}
?>
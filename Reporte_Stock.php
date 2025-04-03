<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// Importamos la biblioteca Dompdf, para procesar el HTML/PDF y generar el PDF
require_once 'dompdf/vendor/autoload.php';
include 'connection.php';

function obtenerConexion() {
    $host = 'localhost';
    $usuario = 'root'; // Reemplaza con tu usuario de MySQL
    $contrasena = 'toto_jk9514Th99'; // Reemplaza con tu contraseña de MySQL
    $base_datos = 'peliculon'; // Reemplaza con el nombre de tu base de datos

    $conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    return $conexion;
}

function stockAgotado($conexion) {
    $consulta_stock_agotado = "SELECT s.nom_suc, p.tit_peli, p.costo_peli, i.exist_inv
    FROM inventario i
    INNER JOIN sucursal s ON i.id_suc = s.id_suc
    INNER JOIN pelicula p ON i.id_peli = p.id_peli
    WHERE i.exist_inv = 0"; // Stock agotado (exist_inv = 0)

    $resultado = mysqli_query($conexion, $consulta_stock_agotado);

    if ($resultado !== false && mysqli_num_rows($resultado) > 0) {
        return $resultado;
    } else {
        return false; // Retornar un valor falso si no hay resultados o hay un error
    }
}

function stockDisponible($conexion) {
    $consulta_stock_disponible = "SELECT s.nom_suc, p.tit_peli, p.costo_peli, i.exist_inv
                                  FROM inventario i
                                  INNER JOIN sucursal s ON i.id_suc = s.id_suc
                                  INNER JOIN pelicula p ON i.id_peli = p.id_peli
                                  WHERE i.exist_inv > 0"; // Stock disponible (exist_inv > 0)

    $resultado = mysqli_query($conexion, $consulta_stock_disponible);

    if ($resultado !== false && mysqli_num_rows($resultado) > 0) {
        return $resultado;
    } else {
        return false; // Retornar un valor falso si no hay resultados o hay un error
    }
}

// Obtener los resultados
$conexion = obtenerConexion(); // Función que devuelve la conexión a la base de datos

$stock_agotado = stockAgotado($conexion);
$stock_disponible = stockDisponible($conexion);

// Contenido HTML del reporte
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Stock Disponible en Cada Sucursal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px; /* Tamaño de fuente ajustado */
        }

        p{
            margin: 5px 0;
            font-size: 14px;.
        }
    </style>
</head>
<body>
    <h2>Reporte de Stock Disponible en Cada Sucursal</h2>
    <p>Empresa: </p>
    <p>Fecha de Generación: ' . date("Y-m-d") . '</p>
    <hr>
    
    <h4>Stock Agotado</h4>
    <p>Productos Mostrados: ' . mysqli_num_rows($stock_agotado) . '</p>
    
    <table>
        <thead>
            <tr>
                <th>Sucursal</th>
                <th>Prenda</th>
                <th>Talla</th>
                <th>Marca</th>
                <th>Existencias</th>
            </tr>
        </thead>
        <tbody>';
            
        if ($stock_agotado !== false)  {

            while ($row = mysqli_fetch_array($stock_agotado)) {
                $html .= '
                <tr>
                <td>' . $row['nom_suc'] . '</td>
                <td>' . $row['tit_peli'] . '</td>
                <td>' . $row['costo_peli'] . '</td>
                <td>' . $row['exist_inv'] . '</td>
                </tr>';
            }
        }
       
$html .= '
        </tbody>
    </table>
    

    <h4>Stock Disponible</h4>
    <p>Productos Mostrados: ' . mysqli_num_rows($stock_disponible) . '</p>

    <table>
        <thead>
            <tr>
                <th>Sucursal</th>
                <th>Prenda</th>
                <th>Talla</th>
                <th>Marca</th>
                <th>Existencias</th>
            </tr>
        </thead>
        <tbody>';
        if ($stock_disponible !== false) {

            while ($row = mysqli_fetch_array($stock_disponible)) {
                $html .= '
                <tr>
                <td>' . $row['nom_suc'] . '</td>
                <td>' . $row['tit_peli'] . '</td>
                <td>' . $row['costo_peli'] . '</td>
                <td>' . $row['exist_inv'] . '</td>
                </tr>';
            }
        }
        
       
$html .= '


</body>
</html>
';

// Crear una instancia de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// Creamos una instancia de Options. Dentro de options podemos habilitar el procesamiento de lenguaje PHP y HTML, con esto evitamos errores en el procesamiento del código de la página que queremos renderizar
$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isHtml5ParserEnabled', true);

// Crear una instancia de Dompdf con las opciones configuradas
$dompdf = new Dompdf($options);

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Renderizar el PDF
$dompdf->render();

// Salida del PDF al navegador
$dompdf->stream('Reporte-de-Ventas.pdf', ['Attachment' => 0]);
?>
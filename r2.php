<?php
$total1=0;
ob_start();
session_start();
include("connection.php");
$date1=$_SESSION["date1"];
$date2=$_SESSION["date2"];


$currentDate = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Peliculon</title>
        <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .detalle-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .detalle-table th,
        .detalle-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                        <div class="card-body">
    <p>Fecha de generación del reporte: <?php echo $currentDate; ?></p>
    <!-- Resto del contenido -->
</div>

                            <div class="row">
                            <br>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Reporte de ventas
                                </div>
                                <div class="card-body">
                                <table class="table-striped">
                                    <thead>
                                        <tr style= 'font-weight: bold;'>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Total General</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $total=0;
                                                include("connection.php");
                                                $date1 = $conexion->real_escape_string($_SESSION["date1"]);
                                                $date2 = $conexion->real_escape_string($_SESSION["date2"]);
                                                $pago = 0;
                                                $sql = "SELECT venta.num_vent, venta.fec_vent, venta.total, cliente.n1_cli, cliente.app_cli,venta.total
                                                from venta
                                                inner join cliente on (cliente.id_cli = venta.id_cli)
                                                inner join venta_inv on (venta_inv.num_vent = venta.num_vent)
                                                WHERE fec_vent BETWEEN '$date1' AND '$date2'";
                                                $result = $conexion->query($sql);
                                                if ($result->num_rows > 0) {
                                                                                       
                                                    $tabla = "";
                                                    
                                                    while ($row = $result->fetch_assoc()) {
                                                                                                                $SQLSAVES = "SELECT p.tit_peli AS Pelicula, p.costo_peli AS Precio_Unitario, vi.cant_prod AS cantidad, (p.costo_peli * vi.cant_prod) AS Subtotal
                                                                                                                FROM venta v
                                                                                                                INNER JOIN venta_inv vi ON v.num_vent = vi.num_vent
                                                                                                                INNER JOIN inventario i ON vi.id_inv = i.id_inv
                                                                                                                INNER JOIN pelicula p ON i.id_peli = p.id_peli
                                                                                                                WHERE v.num_vent = " . $row["num_vent"];
                                                                                                            
                                                                                                    $results = $conexion->query($SQLSAVES);
                                                                                                    if ($results->num_rows > 0) {
                                                                                                        while ($rowS = $results->fetch_assoc()) {
                                                                                                                    $total+=$rowS['Subtotal'];
                                                                                                        }
                                                                                                    }
                                                        
                                                        $tabla .= "
                                                        <tr class='venta-row' data-idventa='" . $row["num_vent"] . "'' style= 'color: blue;'>
                                                            <td>" . $row["num_vent"] . "</td>
                                                            <td>" . $row["fec_vent"] . "</td>
                                                            <td>" . $row["n1_cli"] . " " . $row["app_cli"] . "</td>
                                                            <td>" . $total."</td>
                                                        
                                                            

                                                            
                                                        </tr>
                                                        <tr class='detalle-row';'>
                                                            <td colspan='4'>
                                                                <table class='table-striped'>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Producto</th>
                                                                            <th>Precio</th>
                                                                            <th>Cantidad</th>
                                                                            <th>Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>";
                                                                    $total=0;

                                                                   

                                                                    $sqldown = "SELECT p.tit_peli AS Pelicula, p.costo_peli AS Precio_Unitario, vi.cant_prod AS cantidad, (p.costo_peli * vi.cant_prod) AS Subtotal
                                                                    FROM venta v
                                                                    INNER JOIN venta_inv vi ON v.num_vent = vi.num_vent
                                                                    INNER JOIN inventario i ON vi.id_inv = i.id_inv
                                                                    INNER JOIN pelicula p ON i.id_peli = p.id_peli
                                                                    WHERE v.num_vent = " . $row["num_vent"];
                                                        $results = $conexion->query($sqldown);
                                                        if ($results->num_rows > 0) { 
                                                            while ($rowd = $results->fetch_assoc()) {
                                                                $tabla .= "
                                                                        <tr>
                                                                            <td>" . $rowd["Pelicula"] . "</td>
                                                                            <td>" . $rowd["Precio_Unitario"] . "</td>
                                                                            <td>" . $rowd["cantidad"] . "</td>
                                                                            <td>" . $rowd["Subtotal"] . "</td>
                                                                        </tr>";
                                                            }
                                                        }

                                                        $tabla .= "
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        ";

                                                        $_SESSION["reporte"] = $tabla;
                                                    }
                                                    echo $tabla;
                                                    
                                                } else {
                                                    echo "<h1>No se registraron ventas dentro de este rango de fechas</h1>";
                                                }
                                                $conexion->close();

                                            
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
    </body>
</html>


<?php
$html = ob_get_clean();
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment" => false));
?>
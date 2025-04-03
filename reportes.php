
<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
    // El usuario es un administrador, se permite el acceso a la 
include("connection.php");
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
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="sb-admin-2.css">
        <link rel="stylesheet" href="sb-admin-2.min.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
       
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

            <?php 
             $date1=0;
             $date2=0;
             if(isset($_POST["fini"])){
                $date1=$_POST["fini"];
                $date2=$_POST["fter"];
                $_SESSION["date1"] = $date1;
                $_SESSION["date2"] = $date2;
             }
             ?>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">REPORTES</h1>
                        <h3>Clasifique por fechas</h3>
                        <form method="post">
                            <span class="text-danger">Fecha inicial: 
                            <input type="date" name="fini" value = <?= $date1 ?>> </span>
                            <span class="text-danger">Fecha termino: 
                            <input type="date" name="fter" value = <?= $date2 ?>> </span>
                            <input type="submit" name="consult" value="CONSULTAR" class="btn btn-primary">
                            <a href="r2.php" style ="text-decoration:none; color:red; margin-left: 20rem;">Importar a PDF <i class="fa-solid fa-file-pdf fa-2xl" style="color: #e21212;"></i></a>
                        </form>
                        

                        <div class="row">
                        <br>
                            
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Reporte de ventas
                            </div>
                            <div class="card-body">
                                <script>
                                    $(document).ready(function() {
                                        // Manejar el clic en cada fila de venta
                                        $(".venta-row").on("click", function() {
                                            // Obtener la fila de detalles correspondiente
                                            var detalleRow = $(this).next(".detalle-row");
                                            // Alternar la visibilidad de la fila de detalles al hacer clic en la fila de venta
                                            detalleRow.toggle();
                                        });
                                    });
                                    
                                </script>
                                <table class="table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Cantidad</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(isset($_POST["fini"]) && isset($_POST["fter"])){
                                                include("connection.php");
                                                $date1 = $conexion->real_escape_string($_POST["fini"]);
                                                $date2 = $conexion->real_escape_string($_POST["fter"]);
                                                $total=0;
                                                $sql = "SELECT * FROM venta
                                                inner join cliente on (cliente.id_cli = venta.id_cli)
                                                inner join venta_inv on (venta_inv.num_vent=venta_inv.num_vent)
                                                WHERE fec_vent BETWEEN '$date1' AND '$date2'";
                                                $result = $conexion->query($sql);
                                                if ($result->num_rows > 0) {
                                                    
                                                    $tabla = "";
                                                    while ($row = $result->fetch_assoc()) {
                                                        $tabla .= "
                                                        <tr class='venta-row' data-idventa='" . $row["num_vent"] . "'>
                                                            <td>" . $row["num_vent"] . "</td>
                                                            <td>" . $row["fec_vent"] . "</td>
                                                            <td>"  .$row["cant_prod"]."</td>
                                                            <td>" . $row["n1_cli"] . " " . $row["app_cli"] . "</td>
                                                            <td>".$total."</td>
                                                        </tr>
                                                        <tr class='detalle-row' style='display: none;'>
                                                            <td colspan='4'>
                                                                <table class='table table-bordered'>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Producto</th>
                                                                            <th>Precio</th>
                                                                            <th>Cantidad</th>
                                                                            <th>Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>";

                                                        $sqldown = "SELECT p.tit_peli AS Pelicula, p.costo_peli AS Precio_Unitario, vi.cant_prod AS cantidad, (p.prec_peli * vi.cant_prod) AS Subtotal
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
                                                                        $total+=$rowd['Subtotal'];
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
                                            }else{
                                                $date1=0;
                                                $date2=0;
                                            }
                                            
                                            
                                        ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
} else {
    // Si no es un administrador, redirige a la página de inicio de sesión o a alguna otra página de acceso
    header("Location: inicio de sesion.php");
    exit;
}
?>
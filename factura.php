<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = 'toto_jk9514Th99';
$base_datos = 'peliculon'; // Reemplaza con el nombre de tu base de datos


$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);


if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener el ID de la última venta
$consulta_ultima_venta = "SELECT MAX(num_vent) AS id_ultima_venta FROM venta";

// Ejecutar la consulta para obtener el ID de la última venta
$resultado_ultima_venta = $conexion->query($consulta_ultima_venta);

if ($resultado_ultima_venta) {
    $fila_ultima_venta = $resultado_ultima_venta->fetch_assoc();
    $id_ultima_venta = $fila_ultima_venta['id_ultima_venta'];

    // Consulta para obtener los datos del cliente de la última venta
    $consulta_datos_cliente = "SELECT c.n1_cli AS nombre_cliente, c.rfc_cli, c.tel_cli, c.mail_usu, c.nI_cli,c.nE_cli,c.col_cli,c.calle_cli,c.cp_cli, m.nom_mun
        FROM cliente c 
        INNER JOIN venta v ON c.id_cli = v.id_cli 
        INNER JOIN municipio m ON m.id_mun = c.id_mun
        WHERE v.num_vent = $id_ultima_venta";

    $resultado_datos_cliente = $conexion->query($consulta_datos_cliente);

    if ($resultado_datos_cliente) {
        $fila_cliente = $resultado_datos_cliente->fetch_assoc();

        // Consulta para obtener los detalles de la última venta por sucursal con información del cliente
        $consulta_ultima_venta_detalle_sucursal = "SELECT v.num_vent AS id_venta, v.id_cli AS id_cliente, v.folio_fac AS ticket, v.total, "
        . "v.folio_fac AS folio_factura, v.fec_vent AS fecha, vi.num_vent AS id_detalle_venta, "
        . "vi.id_inv AS id_inventario, vi.cant_prod AS cantidad, i.exist_inv, vi.precio, p.tit_peli AS nombre_producto, "
        . "p.costo_peli AS precio_producto, s.nom_suc AS nombre_sucursal 
    FROM venta v 
    INNER JOIN venta_inv vi ON v.num_vent = vi.num_vent 
    INNER JOIN inventario i ON vi.id_inv = i.id_inv 
    INNER JOIN pelicula p ON i.id_peli = p.id_peli 
    INNER JOIN sucursal s ON i.id_suc = s.id_suc 
    WHERE v.num_vent = $id_ultima_venta
    ORDER BY s.nom_suc";

        $resultado_ultima_venta_detalle_sucursal = $conexion->query($consulta_ultima_venta_detalle_sucursal);

        if ($resultado_ultima_venta_detalle_sucursal) {
            $pago = 0; // Variable para cálculo de subtotal, se inicializa en 0

            echo '<!DOCTYPE html>
                <html>
                <head>
                    <title>Factura - Peliculon</title>
                    <!-- Agregar enlaces a los estilos de Bootstrap -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                    <style>
                        /* Estilos adicionales */
                        .table th,
                        .table td {
                            vertical-align: middle;
                            text-align: center;
                        }
                        .table th {
                            font-weight: bold;
                        }
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                                padding: 20px;
                                background-color: #f8f9fa;
                            }
                            h1, h2, h4 {
                                text-align: center;
                                margin-bottom: 20px;
                            }
                            .container {
                                background-color: #fff;
                                border-radius: 10px;
                                padding: 30px;
                                box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
                            }
                            .table th,
                            .table td {
                                vertical-align: middle;
                                text-align: center;
                            }
                            .table th {
                                font-weight: bold;
                            }
                            /* Botón para imprimir */
                            .btn-primary {
                                margin-top: 20px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1 class="text-center">Factura - Peliculon</h1>
                        <h2 class="mb-4">Datos del Cliente</h2>';

            echo '<div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> ' . $fila_cliente['nombre_cliente'] . '</p>
                            <p><strong>RFC:</strong> ' . $fila_cliente['rfc_cli'] . '</p>
                            <p><strong>Teléfono:</strong> ' . $fila_cliente['tel_cli'] . '</p>
                            <p><strong>Correo:</strong> ' . $fila_cliente['mail_usu'] . '</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Número de Casa:</strong> ' . $fila_cliente['nI_cli'] . '</p>
                            <p><strong>Número de Casa:</strong> ' . $fila_cliente['nE_cli'] . '</p>
                            <p><strong>Calle:</strong> ' . $fila_cliente['col_cli'] . '</p>
                            <p><strong>Colonia:</strong> ' . $fila_cliente['calle_cli'] . '</p>
                            <p><strong>Estado:</strong> ' . $fila_cliente['nom_mun'] . '</p>
                        </div>
                    </div>';

            echo '<h2 class="mb-4">Detalle de la Venta</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Sucursal</th>
                                <th>Precio Unitario</th>
                                <th>Precio Total</th>
                            </tr>
                        </thead>
                        <tbody>';

            while ($fila = $resultado_ultima_venta_detalle_sucursal->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $fila['nombre_producto'] . '</td>';
                echo '<td>' . $fila['cantidad'] . '</td>';
                echo '<td>' . $fila['nombre_sucursal'] . '</td>';
                echo '<td>' . $fila['precio_producto'] . '</td>';
                $precio_total = $fila['cantidad'] * $fila['precio_producto'];
                echo '<td>' . $precio_total . '</td>';
                echo '</tr>';
                $pago += $precio_total; // Suma para obtener el monto total de la factura
            }

            echo '</tbody>
                </table>';

            $subtotal = $pago / 1.16; // Cálculo de subtotal
            $iva = $subtotal * 0.16; // Cálculo de IVA (16%)
            $total = $pago; // Total

            echo '<h4 class="mt-4">Resumen</h4>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <p><strong>Subtotal:</strong> ' . number_format($subtotal, 2) . '</p>
                            <p><strong>IVA:</strong> ' . number_format($iva, 2) . '</p>
                            <p><strong>Total:</strong> ' . number_format($total, 2) . '</p>
                        </div>
                    </div>';

            echo '</div>
                <!-- Agregar botón para imprimir -->
                <div class="text-center mt-4">
                    <button onclick="imprimirFactura()" class="btn btn-primary">Imprimir Factura</button>
                </div>
                <!-- Agregar enlaces a los scripts de Bootstrap -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"></script>
                <!-- Agregar script para la funcionalidad de impresión -->
                <script>
                    function imprimirFactura() {
                        window.print(); // Abre la ventana de impresión del navegador
                    }
                </script>
                </body>
                </html>';
        } else {
            echo "Error al obtener los detalles de la última venta por sucursal con información del cliente: " . $conexion->error;
        }
    } else {
        echo "Error al obtener los datos del cliente de la última venta: " . $conexion->error;
    }
} else {
    echo "Error al obtener el ID de la última venta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
<?php
session_start();

if (isset($_SESSION['total']) && !empty($_SESSION['total'])) {
    // Obtener el valor de pago de la sesión
    $pago = $_SESSION['total'];

    $servername = "localhost";
    $username = "root";
    $password = "toto_jk9514Th99";
    $dbname = "peliculon";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    function obtenerIDInventario($id_inv) {
        global $conn;
        $query = "SELECT id_inv FROM inventario WHERE id_inv = '$id_inv'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['id_inv'];
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            return null;
        }
    }
    
    function obtenerInformacionProducto($id_inv) {
        global $conn;
    
        $query = "SELECT pelicula.id_peli,pelicula.tit_peli, pelicula.costo_peli FROM inventario
                  INNER JOIN pelicula ON inventario.id_peli = pelicula.id_peli
                  WHERE inventario.id_inv = '$id_inv'";
        
        $result = mysqli_query($conn, $query);
    
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return array(
                'id' => $row['id_peli'],
                'nombre'=> $row['tit_peli'],
            );
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            return null;
        }
    }
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        $id_usuario = $_SESSION['id_cli'];
        $sql_cliente = "SELECT id_cli FROM cliente WHERE id_cli = '$id_usuario'";
        $result_cliente = $conn->query($sql_cliente);

        // Confirmación de la compra y actualización del inventario
        foreach ($_SESSION['carrito'] as $inventario_id => $detalle) {
            $producto_info = obtenerInformacionProducto($inventario_id);
            $producto_id = $producto_info['id'];
            $cantidad_producto = $detalle['cantidad'];

            // Restar la cantidad comprada de las existencias en la tabla de inventario
            $sql_actualizar_existencias = "UPDATE inventario SET exist_inv = exist_inv - $cantidad_producto WHERE id_inv= '$inventario_id'";


            // Ejecutar la consulta para actualizar las existencias
            if ($conn->query($sql_actualizar_existencias) !== TRUE) {
                die("Error al actualizar existencias: " . $conn->error);
            }
        }

        if ($result_cliente->num_rows > 0) {
            $row_cliente = $result_cliente->fetch_assoc();
            $id_cliente = $row_cliente['id_cli'];

            // Generar un número de ticket único
            $ticket = uniqid();

            // Generar un número aleatorio para el folio de factura
            $folio_factura = rand(1000, 9999); // Cambia el rango según tus necesidades

            // Obtener la fecha actual
            $fecha_actual = date("Y-m-d");
            $stmt_venta = $conn->prepare("INSERT INTO venta (fec_vent, id_cli, total, folio_fac) VALUES (?, ?, ?, ?)");
            $stmt_venta->bind_param("sids", $fecha_actual, $id_cliente, $pago, $folio_factura);
            
            $stmt_venta->execute();
            $id_venta = $stmt_venta->insert_id; // Obtener el ID de la venta recién insertada
            $stmt_venta->close();

            foreach ($_SESSION['carrito'] as $inventario_id => $detalle){
                $producto_info = obtenerInformacionProducto($inventario_id);
                $producto_id = $producto_info['id'];
                $cantidad_producto = $detalle['cantidad'];
                
                // Obtener el precio del producto desde la tabla productos
                $sql_precio_producto = "SELECT costo_peli FROM pelicula WHERE id_peli = $producto_id";
                $result_precio_producto = $conn->query($sql_precio_producto);
                
                if ($result_precio_producto->num_rows > 0) {
                    $row_precio_producto = $result_precio_producto->fetch_assoc();
                    $precio_unitario = $row_precio_producto['costo_peli'];

                    // Obtener el ID del inventario correspondiente al producto y la sucursal
                    $id_inventario = obtenerIDInventario($inventario_id);

                    if ($id_inventario !== null) {
                        // Realizar la inserción en la tabla detalle_venta
                        $stmt_detalle_venta = $conn->prepare("INSERT INTO venta_inv (num_vent, id_inv, cant_prod, precio) VALUES (?, ?, ?, ?)");
                        $stmt_detalle_venta->bind_param("iiid", $id_venta, $id_inventario, $cantidad_producto, $precio_unitario);

                        // Ejecutar la inserción
                        $stmt_detalle_venta->execute();

                        // Verificar y manejar los errores si es necesario
                        if ($stmt_detalle_venta->errno) {
                            echo "Error al insertar detalles de venta: " . $stmt_detalle_venta->error;
                            // Aquí puedes manejar el error de la inserción de alguna manera, como revertir transacciones, etc.
                        }
                    } else {
                        echo "No se encontró el inventario para el producto con ID $producto_id en la sucursal ".$producto['sucursal_id'];
                        // Manejar la situación donde no se encuentra el inventario correspondiente
                        // Puedes detener la inserción o manejarla de acuerdo a tu lógica de negocio
                    }
                } else {
                    echo "No se encontró el precio para el producto con ID $producto_id.";
                    // Manejar la situación donde no se encuentra el precio del producto
                    // Puedes detener la inserción o manejarla de acuerdo a tu lógica de negocio
                }
            }

            // Limpiar el carrito después d
            // Limpiar el carrito después de procesar la compra
            unset($_SESSION['carrito']);

            // Cerrar la conexión a la base de datos
            $conn->close();

            // Redirigir a una página de confirmación
            header('Location: confirmarcompra.php');
            exit;
        
        } else {
            echo "No se encontró el ID del cliente para este usuario.";
        }
    } else {
        // Mensaje si no hay productos en el carrito para comprar
        echo "<h2>Error en la compra</h2>";
        echo "<p>No hay productos en el carrito para procesar la compra.</p>";
        echo '<a href="homepagecli.php">Volver a la página principal</a>';
    }
 } else {
    // Si no está definida la variable de sesión 'pago'
    echo "<h2>Error en la compra</h2>";
    echo "<p>No se encontró el total de la compra.</p>";
    echo '<a href="homepagecli.php">Volver a la página principal</a>';
}

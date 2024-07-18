
<?php

require_once("../config/conexion.php");

class Clase_Orden
{

    public function listar()
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT o.orden_id, o.cliente_id, c.nombre, c.apellido, o.fecha, o.total 
                FROM ordenes o 
                INNER JOIN clientes c ON c.id_cliente = o.cliente_id";
        $result = $con->query($sql);

        $con->close();
        return $result;
    }

    public function insertar($cliente_id)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO ordenes (cliente_id, total) VALUES (?, 0)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $cliente_id);

        if ($stmt->execute()) {
            $mensaje = "Orden insertada con éxito.";
        } else {
            $mensaje = "Error al insertar la orden: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
        return $mensaje;
    }

    public function eliminar($orden_id)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "DELETE FROM ordenes WHERE orden_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $orden_id);

        if ($stmt->execute()) {
            $mensaje = "Orden eliminada con éxito.";
        } else {
            $mensaje = "Error al eliminar la orden: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
        return $mensaje;
    }

    public function insertarDetalleOrden($orden_id, $nombre_menu, $cantidad)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        // Llamada al procedimiento almacenado
        $sql = "CALL insertarDetalleOrden(?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isi", $orden_id, $nombre_menu, $cantidad);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Detalle de la orden insertado con éxito.");
        } else {
            $respuesta = array("message" => "Error al insertar detalle de la orden: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }


    public function obtenerDetallesOrden($orden_id)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT do.detalle_id, m.nombre, m.precio, do.cantidad, do.subtotal
            FROM detalle_ordenes as do
            JOIN menus m ON do.menu_id = m.menu_id
            WHERE do.orden_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $orden_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $detalles = array();
        while ($fila = $resultado->fetch_assoc()) {
            $detalles[] = $fila;
        }

        $stmt->close();
        $con->close();

        return $detalles;
    }

    public function actualizarCantidadDetalleOrden($detalle_id, $cantidad) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        $sql = "CALL actualizarDetalleOrden(?, ?)"; // Asegúrate de que el procedimiento almacenado esté correctamente definido en la base de datos
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $detalle_id, $cantidad);
    
        $resultado = $stmt->execute();
    
        if ($resultado) {
            $respuesta = "Detalle de la orden actualizado con éxito.";
        } else {
            $respuesta = "Error al actualizar detalle de la orden: " . $stmt->error;
        }
    
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }


    public function eliminarDetalleOrden($detalle_id)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        // Llamada al procedimiento almacenado
        $sql = "CALL eliminarDetalleOrden(?)";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $detalle_id);

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje = "Detalle de la orden eliminado con éxito.";
        } else {
            $mensaje = "Error al eliminar detalle de la orden: " . $stmt->error;
        }

        $stmt->close();
        $con->close();

        return $mensaje;
    }
}

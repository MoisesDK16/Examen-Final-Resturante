<?php

require_once("../models/orden.model.php");

$orden = new Clase_Orden();

switch ($_GET["op"]) {

    case "listar":
        $listaOrdenes = array();
        $dato = $orden->listar();

        while ($fila = $dato->fetch_assoc()) {
            $listaOrdenes[] = $fila;
        }
        echo json_encode($listaOrdenes);
    break;

    case "insertar":
        $cliente_id = $_POST["cliente_id"];

        if (!empty($cliente_id)) {
            $mensaje = $orden->insertar($cliente_id);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al insertar la orden: Cliente ID no proporcionado."));
        }
    break;

    case "eliminar":
        $orden_id = $_POST["orden_id"];

        if (!empty($orden_id)) {
            $mensaje = $orden->eliminar($orden_id);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al eliminar la orden: Orden ID no proporcionado."));
        }
    break;

    case "obtenerDetallesOrden":
        if (!empty($_GET["orden_id"])) {
            $orden_id = $_GET["orden_id"];
            $detalles = $orden->obtenerDetallesOrden($orden_id);
            echo json_encode($detalles);
        } else {
            echo json_encode(array("message" => "ID de la orden no proporcionado."));
        }
    break;

    case "insertarDetalleOrden":
        $orden_id_detalle = $_POST["orden_id_detalle"];
        $nombre_menu_detalle = $_POST["menu_detalle"];
        $cantidad_detalle = $_POST["cantidad_detalle"];

        if(!empty($orden_id_detalle) && !empty($nombre_menu_detalle)) {
            $mensaje = $orden->insertarDetalleOrden($orden_id_detalle, $nombre_menu_detalle, $cantidad_detalle);
            echo json_encode($mensaje);
        } else {
            echo json_encode(array("message" => "Error al insertar el detalle de la orden: Datos incompletos."));
        }
    break;

    case "actualizarDetalle":
        if (isset($_POST["detalle_id"]) && isset($_POST["cantidad"])) {
            $detalle_id = $_POST["detalle_id"];
            $cantidad = $_POST["cantidad"];
            
            if (!empty($detalle_id) && !empty($cantidad)) {
                $mensaje = $orden->actualizarCantidadDetalleOrden($detalle_id, $cantidad);
                echo json_encode(array("message" => $mensaje));
            } else {
                echo json_encode(array("message" => "Error al actualizar detalle de la orden: Datos incompletos."));
            }
        } else {
            echo json_encode(array("message" => "Error al actualizar detalle de la orden: Datos no proporcionados."));
        }
    break;
    

    case "eliminarDetalle":
        if (isset($_POST["detalle_id"]) && !empty($_POST["detalle_id"])) {
            $detalle_id = $_POST["detalle_id"];
            $mensaje = $orden->eliminarDetalleOrden($detalle_id);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al eliminar detalle de la orden: ID no proporcionado."));
        }
    break;


    default:
        echo json_encode(array("message" => "Operación no válida"));
    break;
    
}

?>

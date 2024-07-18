<?php

require_once("../models/menu.model.php");

$menu = new Clase_Menu();

switch ($_GET["op"]) {

    case "listar":
        $listaMenus = array();
        $dato = $menu->listar();

        while ($fila = $dato->fetch_assoc()) {
            $listaMenus[] = $fila;
        }
        echo json_encode($listaMenus);
    break;
    
        // $datos = json_decode(file_get_contents('php://input'));

        // if (!empty($datos->nombre) && !empty($datos->descripcion) && !empty($datos->precio) && isset($datos->disponible)) {
        //     $mensaje = $menu->insertarMenu($datos->nombre, $datos->descripcion, $datos->precio, $datos->disponible);
        //     echo json_encode(array("message" => $mensaje));
        // } else {
        //     echo json_encode(array("message" => "Error al insertar el menú: Datos incompletos."));
        // }


    case "insertar":
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $precio = $_POST["precio"];
        $disponible = $_POST["disponible"];

        if (!empty($nombre) && !empty($descripcion) && !empty($precio) && isset($disponible)) {
            $mensaje = $menu->insertarMenu($nombre, $descripcion, $precio, $disponible);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al insertar el menú: Datos incompletos."));
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents('php://input'));

        if (!empty($datos->menu_id) && !empty($datos->nombre) && !empty($datos->descripcion) && !empty($datos->precio) && isset($datos->disponible)) {
            $mensaje = $menu->actualizarMenu($datos->menu_id, $datos->nombre, $datos->descripcion, $datos->precio, $datos->disponible);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al actualizar el menú: Datos incompletos."));
        }
    break;

    case "eliminar":
        $datos = json_decode(file_get_contents('php://input'));

        if (!empty($datos->menu_id)) {
            $mensaje = $menu->eliminarMenu($datos->menu_id);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al eliminar el menú: ID no proporcionado."));
        }
    break;

    case "uno":
        $menu_id = $_GET["menu_id"];

        if (!empty($menu_id)) {
            $dato = $menu->uno($menu_id);

            if ($dato) {
                echo json_encode($dato);
            } else {
                echo json_encode(array("message" => "Menú no encontrado"));
            }
        } else {
            echo json_encode(array("message" => "Error al obtener el menú: ID no proporcionado."));
        }
    break;

    case "listarMenuDisponible":
        $listaMenus = array();
        $dato = $menu->listarMenuDisponible();

        while($fila = $dato->fetch_assoc()) {
            $listaMenus[] = $fila;
        }
        echo json_encode($listaMenus);
    break;

    default:
        echo json_encode(array("message" => "Operación no válida"));
    break;
}

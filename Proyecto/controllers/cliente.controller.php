<?php

require_once("../models/cliente.model.php");

$cliente = new Clase_Cliente();

switch ($_GET["op"]) {

    case "listar":
        $listaClientes = array();
        $dato = $cliente->listar();

        while ($fila = $dato->fetch_assoc()) {
            $listaClientes[] = $fila;
        }
        echo json_encode($listaClientes);
    break;

    case "insertar":
        $id_cliente = $_POST["id_cliente"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];

        if(!empty($id_cliente) && !empty($nombre) && !empty($apellido) && !empty($email) && !empty($telefono)){
            $mensaje = $cliente->insertarClientes($id_cliente, $nombre, $apellido, $email, $telefono);
            echo $mensaje;
        }else{
            echo "Error al insertar el cliente: Datos incompletos.";
        }
        // $datos = json_decode(file_get_contents('php://input')

        // if (!empty($datos->id_cliente) && !empty($datos->nombre) && !empty($datos->apellido) && !empty($datos->email) && !empty($datos->telefono)) {
        //     $mensaje = $cliente->insertarClientes($datos->id_cliente, $datos->nombre, $datos->apellido, $datos->email, $datos->telefono);
        //     echo $mensaje;
        // } else {
        //     echo "Error al insertar el cliente: Datos incompletos.";
        // }        
    break;

    case "actualizar":

        $id_cliente = $_POST["Editid_cliente"];
        $nombre = $_POST["Editnombre"];
        $apellido = $_POST["Editapellido"];
        $email = $_POST["Editemail"];
        $telefono = $_POST["Edittelefono"];

        if(!empty($id_cliente) && !empty($nombre) && !empty($apellido) && !empty($email) && !empty($telefono)){
            $mensaje = $cliente->actualizarCliente($id_cliente, $nombre, $apellido, $email, $telefono);
            echo $mensaje;
        }else{
            echo "Error al actualizar el cliente: Datos incompletos.";
        }

        // $datos = json_decode(file_get_contents('php://input'));

        // if (!empty($datos->id_cliente) && !empty($datos->nombre) && !empty($datos->apellido) && !empty($datos->email) && !empty($datos->telefono)) {
        //     $mensaje = $cliente->actualizarCliente($datos->id_cliente, $datos->nombre, $datos->apellido, $datos->email, $datos->telefono);
        //     echo $mensaje;
        // } else {
        //     echo "Error al actualizar el cliente: Datos incompletos.";
        // }
    break;

    case "eliminar":
        if (!empty($_POST['id_cliente'])) {
            $id_cliente = $_POST['id_cliente'];
            $mensaje = $cliente->eliminarCliente($id_cliente);
            echo json_encode(array("message" => $mensaje));
        } else {
            echo json_encode(array("message" => "Error al eliminar el cliente: ID no proporcionado."));
        }
    break;

    
    case "uno":
        $id_cliente = $_GET["id_cliente"];

        if (!empty($id_cliente)) {
            $dato = $cliente->uno($id_cliente);

            if ($dato) {
                echo json_encode($dato);
            } else {
                echo "Cliente no encontrado";
            }
        } else {
            echo "Error al obtener el cliente: ID no proporcionado.";
        }
    break;

    default:
        echo "Operación no válida";
        break;
}
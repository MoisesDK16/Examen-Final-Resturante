
<?php 

require_once("../config/conexion.php");

class Clase_Cliente {

    public function insertarClientes($id_cliente, $nombre, $apellido, $email, $telefono){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO Clientes (id_cliente, nombre, apellido, email, telefono) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $id_cliente, $nombre, $apellido, $email, $telefono);

        if ($stmt->execute()) {
            return "Cliente insertado con éxito.";
        } else {
            return "Error al insertar cliente: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }

    public function listar(){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM Clientes";
        $result = $con->query($sql);

        $con->close();
        return $result;
    }

    public function actualizarCliente($id_cliente, $nombre, $apellido, $email, $telefono){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE Clientes SET nombre = ?, apellido = ?, email = ?, telefono = ? WHERE id_cliente = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $telefono, $id_cliente);

        if ($stmt->execute()) {
            return "Cliente actualizado con éxito.";
        } else {
            return "Error al actualizar cliente: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }

    public function eliminarCliente($id_cliente){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "DELETE FROM Clientes WHERE id_cliente = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $id_cliente);

        if ($stmt->execute()) {
            return "Cliente eliminado con éxito.";
        } else {
            return "Error al eliminar cliente: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }

    public function uno($id_cliente){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM Clientes WHERE id_cliente = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $id_cliente);
        $stmt->execute();

        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();

        $stmt->close();
        $con->close();
        return $cliente;
    }
}

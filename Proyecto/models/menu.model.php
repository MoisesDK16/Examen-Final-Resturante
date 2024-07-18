
<?php 

require_once("../config/conexion.php");

class Clase_Menu {

    public function insertarMenu($nombre, $descripcion, $precio, $disponible) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO Menus (nombre, descripcion, precio, disponible) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $disponible);

        if ($stmt->execute()) {
            return "Menú insertado con éxito.";
        } else {
            return "Error al insertar menú: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }

    public function listar() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM Menus";
        $result = $con->query($sql);

        $con->close();
        return $result;
    }

    public function actualizarMenu($menu_id, $nombre, $descripcion, $precio, $disponible) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE Menus SET nombre = ?, descripcion = ?, precio = ?, disponible = ? WHERE menu_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $disponible, $menu_id);

        if ($stmt->execute()) {
            return "Menú actualizado con éxito.";
        } else {
            return "Error al actualizar menú: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }


    public function eliminarMenu($menu_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "DELETE FROM Menus WHERE menu_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $menu_id);

        if ($stmt->execute()) {
            return "Menú eliminado con éxito.";
        } else {
            return "Error al eliminar menú: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }

    public function uno($menu_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM Menus WHERE menu_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $menu = $result->fetch_assoc();

        $stmt->close();
        $con->close();
        return $menu;
    }

    public function listarMenuDisponible() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM Menus WHERE disponible = 1";
        $result = $con->query($sql);

        $con->close();
        return $result;
    }
}
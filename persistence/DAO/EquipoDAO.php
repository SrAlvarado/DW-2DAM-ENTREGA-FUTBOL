<?php
/**
 * @title: DAO de Equipos
 * @description: Gestiona el acceso a la tabla 'equipos' en la BBDD.
 *
 * @version    1.0
 *
 * @author     Markel Alvarado
 */

$dir = __DIR__;
require_once $dir . '/../conf/PersistentManager.php';

class EquipoDAO {

    //Conexión a BD
    protected $conn = null;

    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }

    /**
     * Obtiene todos los equipos ordenados por nombre
     */
    public function selectAll() {
        $query = "SELECT * FROM equipos ORDER BY nombre ASC";
        $result = mysqli_query($this->conn, $query);
        $equipos = array();

        while ($equipoBD = mysqli_fetch_array($result)) {
            $equipo = array(
                'id_equipo' => $equipoBD["id_equipo"],
                'nombre' => $equipoBD["nombre"],
                'estadio' => $equipoBD["estadio"],
            );
            array_push($equipos, $equipo);
        }
        return $equipos;
    }

    /**
     * Inserta un nuevo equipo
     */
    public function insert($nombre, $estadio) {
        $query = "INSERT INTO equipos (nombre, estadio) VALUES(?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $nombre, $estadio);
        return $stmt->execute();
    }

    /**
     * Selecciona un equipo por su ID
     */
    public function selectById($id) {
        $query = "SELECT * FROM equipos WHERE id_equipo = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Obtenemos el resultado

        $equipo = null;
        if ($equipoBD = mysqli_fetch_array($result)) {
            $equipo = array(
                'id_equipo' => $equipoBD["id_equipo"],
                'nombre' => $equipoBD["nombre"],
                'estadio' => $equipoBD["estadio"]
            );
        }
        return $equipo;
    }
}
?>
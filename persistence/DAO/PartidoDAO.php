<?php
/**
 * @title: DAO de Partidos
 * @description: Gestiona la BBDD para la tabla 'partidos'.
 *
 * @version    1.0
 *
 * @author     Markel Alvarado
 */

$dir = __DIR__;
require_once $dir . '/../conf/PersistentManager.php';

class PartidoDAO {

    private $conn;

    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }

    /**
     * Selecciona todos los partidos de un equipo específico (local o visitante).
     * @param int $id_equipo
     * @return array
     */
    public function selectByEquipo($id_equipo) {
        $query = "SELECT 
                    p.jornada,
                    p.resultado,
                    e_local.nombre AS nombre_local,
                    e_visitante.nombre AS nombre_visitante,
                    e_local.estadio AS estadio_partido
                  FROM partidos p
                  JOIN equipos e_local ON p.id_local = e_local.id_equipo
                  JOIN equipos e_visitante ON p.id_visitante = e_visitante.id_equipo
                  WHERE p.id_local = ? OR p.id_visitante = ?
                  ORDER BY p.jornada ASC";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $id_equipo, $id_equipo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = array();
        while ($partidoBD = mysqli_fetch_array($result)) {
            $partidos[] = $partidoBD;
        }
        return $partidos;
    }

    /**
     * Obtiene una lista de todas las jornadas únicas que tienen partidos.
     * @return array
     */
    public function getJornadas() {
        $query = "SELECT DISTINCT jornada FROM partidos ORDER BY jornada ASC";
        $result = mysqli_query($this->conn, $query);

        $jornadas = array();
        while ($jornadaBD = mysqli_fetch_array($result)) {
            $jornadas[] = $jornadaBD;
        }
        return $jornadas;
    }

    /**
     * Selecciona todos los partidos de una jornada específica.
     * @param int $jornada
     * @return array
     */
    public function selectByJornada($jornada) {
        $query = "SELECT 
                    p.jornada,
                    p.resultado,
                    e_local.nombre AS nombre_local,
                    e_visitante.nombre AS nombre_visitante,
                    e_local.estadio AS estadio_partido
                  FROM partidos p
                  JOIN equipos e_local ON p.id_local = e_local.id_equipo
                  JOIN equipos e_visitante ON p.id_visitante = e_visitante.id_equipo
                  WHERE p.jornada = ?
                  ORDER BY p.id_partido ASC";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = array();
        while ($partidoBD = mysqli_fetch_array($result)) {
            $partidos[] = $partidoBD;
        }
        return $partidos;
    }

    /**
     * Comprueba si un partido entre dos equipos (en cualquier dirección) ya existe.
     * @param int $id_local
     * @param int $id_visitante
     * @return bool
     */
    public function checkPartidoExists($id_local, $id_visitante) {
        $query = "SELECT id_partido FROM partidos 
                  WHERE (id_local = ? AND id_visitante = ?) 
                     OR (id_local = ? AND id_visitante = ?)";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiii', $id_local, $id_visitante, $id_visitante, $id_local);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        return mysqli_stmt_num_rows($stmt) > 0;
    }

    /**
     * Inserta un nuevo partido en la base de datos.
     * @param int $jornada
     * @param int $id_local
     * @param int $id_visitante
     * @param string $resultado
     * @return bool
     */
    public function insert($jornada, $id_local, $id_visitante, $resultado) {
        $query = "INSERT INTO partidos (jornada, id_local, id_visitante, resultado) 
                  VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiss', $jornada, $id_local, $id_visitante, $resultado);

        return $stmt->execute();
    }

    /**
     * @param $jornadaIntroducida
     * @return bool
     *
     * Pasada una jornada comprobar que exista en la bbdd, si no existe, se pondrá una jornada siguiente a la ultima
     */
        public function saberSiLaJornadaIntroducidaSigueElOrdenDeJornadas($jornadaIntroducida){
        $query = "SELECT MAX(jornada) AS ultima_jornada FROM partidos";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        $ultima_jornada = $row['ultima_jornada'];

        if ($ultima_jornada === null) {
            return true;
        }

        return $jornadaIntroducida <= $ultima_jornada || $jornadaIntroducida == ($ultima_jornada + 1);
    }

}
?>



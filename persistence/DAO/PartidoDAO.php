<?php

/**
 * @title: DAO de Partidos
 * @description: Gestiona el acceso a la tabla 'partidos' en la BBDD.
 *
 * @version    1.0
 *
 * @author     Tu Nombre
 */

$dir = __DIR__;
require_once $dir . '/../conf/PersistentManager.php';

class PartidoDAO
{

    //Conexión a BD
    protected $conn = null;

    public function __construct()
    {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }

    /**
     * Obtiene todos los partidos de un equipo específico (local o visitante).
     * Devuelve los nombres de los equipos y el estadio gracias a los JOINs.
     */
    public function selectByEquipo($id_equipo)
    {

        // Esta query es más compleja:
        // 1. Selecciona los datos del partido (jornada, resultado).
        // 2. USA JOINS para obtener el NOMBRE del equipo local (local.nombre).
        // 3. USA JOINS para obtener el NOMBRE del equipo visitante (visitante.nombre).
        // 4. USA UN JOIN ADICIONAL para obtener el ESTADIO donde se jugó (basado en el ID local).
        // 5. Filtra WHERE el id_equipo que nos pasan es el local O el visitante.
        // 6. Ordena por jornada.

        $query = "
      SELECT 
        p.id_partido,
        p.jornada,
        p.resultado,
        local.nombre AS nombre_local,
        visitante.nombre AS nombre_visitante,
        estadio.estadio AS estadio_partido
      FROM partidos p
      JOIN equipos local ON p.id_local = local.id_equipo
      JOIN equipos visitante ON p.id_visitante = visitante.id_equipo
      JOIN equipos estadio ON p.id_local = estadio.id_equipo
      WHERE p.id_local = ? OR p.id_visitante = ?
      ORDER BY p.jornada ASC
    ";

        $stmt = mysqli_prepare($this->conn, $query);
        // Usamos 'ii' porque pasamos el $id_equipo dos veces (para el WHERE ... OR ...)
        mysqli_stmt_bind_param($stmt, 'ii', $id_equipo, $id_equipo);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $partidos = array();

        while ($partidoBD = mysqli_fetch_array($result)) {
            $partido = array(
                'id_partido' => $partidoBD["id_partido"],
                'jornada' => $partidoBD["jornada"],
                'resultado' => $partidoBD["resultado"],
                'nombre_local' => $partidoBD["nombre_local"],
                'nombre_visitante' => $partidoBD["nombre_visitante"],
                'estadio_partido' => $partidoBD["estadio_partido"],
            );
            array_push($partidos, $partido);
        }
        return $partidos;
    }

    // (Añadiremos más métodos aquí en el siguiente paso)
}


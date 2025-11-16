<?php
require_once('Conexion.php');
require_once('Habitacion.php');
require_once('Huesped.php');

class Reservacion{
    public $idReservacion;
    public $idHuesped;
    public $idHabitacion;
    public $fechaEntrada;
    public $fechaSalida;
    public $estado;
    public $tipoHabitacion;
    public $nombreHuesped;
    private $conexion;

    public function __construct(){
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }

    public function insertar(){
        // Validar fechas
        if(strtotime($this->fechaSalida) <= strtotime($this->fechaEntrada)){
            error_log("Error: Fecha de salida debe ser posterior a fecha de entrada");
            return false;
        }
        
        // Verificar disponibilidad
        if(!$this->habitacionDisponible()){
            error_log("Error: Habitación no disponible para las fechas seleccionadas");
            return false;
        }

        try {
            $ins = $this->conexion->enlace->prepare('INSERT INTO reservaciones (idHuesped, idHabitacion, fechaEntrada, fechaSalida, estado) VALUES(?,?,?,?,?)');
            $ins->bind_param('sssss', $this->idHuesped, $this->idHabitacion, $this->fechaEntrada, $this->fechaSalida, $this->estado);
            $res = $ins->execute();
            
            if($res){
                $this->idReservacion = $ins->insert_id;
                error_log("Reservación insertada exitosamente. ID: " . $this->idReservacion);
                
                // Actualizar estado de la habitación
                $habitacion = new Habitacion();
                $habitaciones = $habitacion->consultar("idHabitacion='".$this->idHabitacion."'");
                if(count($habitaciones)>0){
                    $habitacion = $habitaciones[0];
                    $habitacion->estado = 'Ocupada';
                    $habitacion->actualizar();
                    error_log("Estado de habitación actualizado a Ocupada");
                }
                return true;
            } else {
                error_log("Error al ejecutar inserción: " . $this->conexion->enlace->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Excepción al insertar reservación: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar(){
        if(strtotime($this->fechaSalida) <= strtotime($this->fechaEntrada)){
            error_log("Error: Fecha de salida debe ser posterior a fecha de entrada");
            return false;
        }

        try {
            $ins = $this->conexion->enlace->prepare('UPDATE reservaciones SET idHuesped=?, idHabitacion=?, fechaEntrada=?, fechaSalida=?, estado=? WHERE idReservacion=?');
            $ins->bind_param('sssssi', $this->idHuesped, $this->idHabitacion, $this->fechaEntrada, $this->fechaSalida, $this->estado, $this->idReservacion);
            $res = $ins->execute();
            
            if($res){
                error_log("Reservación actualizada exitosamente. ID: " . $this->idReservacion);
                return true;
            } else {
                error_log("Error al actualizar reservación: " . $this->conexion->enlace->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Excepción al actualizar reservación: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar(){
        try {
            // Primero obtener información de la reserva antes de eliminar
            $reserva_actual = $this->consultar("idReservacion = " . $this->idReservacion);
            if(count($reserva_actual) == 0) {
                error_log("Error: No se encontró la reservación a eliminar");
                return false;
            }
            
            $ins = $this->conexion->enlace->prepare('DELETE FROM reservaciones WHERE idReservacion=?');
            $ins->bind_param('i', $this->idReservacion);
            $res = $ins->execute();
            
            if($res){
                error_log("Reservación eliminada exitosamente. ID: " . $this->idReservacion);
                
                // Actualizar estado de la habitación a Disponible
                $habitacion = new Habitacion();
                $habitaciones = $habitacion->consultar("idHabitacion='".$this->idHabitacion."'");
                if(count($habitaciones)>0){
                    $habitacion = $habitaciones[0];
                    $habitacion->estado = 'Disponible';
                    $habitacion->actualizar();
                    error_log("Estado de habitación actualizado a Disponible");
                }
                return true;
            } else {
                error_log("Error al eliminar reservación: " . $this->conexion->enlace->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Excepción al eliminar reservación: " . $e->getMessage());
            return false;
        }
    }

    public function consultar($condicion=null){
        $condicion = $condicion != null ? ' WHERE '.$condicion : '';
        
        // Consulta corregida con alias correctos
        $query = "SELECT r.*, h.nombre as nombreHuesped, ha.tipo as tipoHabitacion 
                 FROM reservaciones r
                 JOIN huespedes h ON r.idHuesped = h.idHuesped
                 JOIN habitaciones ha ON r.idHabitacion = ha.idHabitacion" . $condicion;
                 
        error_log("Ejecutando consulta de reservaciones: " . $query);
        
        $result = mysqli_query($this->conexion->enlace, $query);
        
        if (!$result) {
            error_log("Error en consulta SQL: " . mysqli_error($this->conexion->enlace));
            return array();
        }
        
        $reservaciones = array();
        
        if ($result && $result->num_rows > 0) {
            while($fila = $result->fetch_assoc()){
                $r = new Reservacion();
                $r->idReservacion = $fila['idReservacion'];
                $r->idHuesped = $fila['idHuesped'];
                $r->idHabitacion = $fila['idHabitacion'];
                $r->fechaEntrada = $fila['fechaEntrada'];
                $r->fechaSalida = $fila['fechaSalida'];
                $r->estado = $fila['estado'];
                $r->nombreHuesped = $fila['nombreHuesped'];
                $r->tipoHabitacion = $fila['tipoHabitacion'];
                $reservaciones[] = $r;
            }
            $result->close();
            error_log("Se encontraron " . count($reservaciones) . " reservaciones");
        } else {
            error_log("No se encontraron reservaciones con la condición: " . $condicion);
        }
        
        return $reservaciones;
    }

    private function habitacionDisponible(){
        $query = "SELECT COUNT(*) as total FROM reservaciones 
                 WHERE idHabitacion = ? 
                 AND estado != 'Cancelada'
                 AND ((fechaEntrada <= ? AND fechaSalida >= ?) 
                     OR (fechaEntrada <= ? AND fechaSalida >= ?) 
                     OR (fechaEntrada >= ? AND fechaSalida <= ?))";
        
        $stmt = $this->conexion->enlace->prepare($query);
        if (!$stmt) {
            error_log("Error preparando consulta de disponibilidad: " . $this->conexion->enlace->error);
            return false;
        }
        
        $stmt->bind_param('sssssss', $this->idHabitacion, 
                         $this->fechaEntrada, $this->fechaEntrada,
                         $this->fechaSalida, $this->fechaSalida,
                         $this->fechaEntrada, $this->fechaSalida);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            error_log("Error ejecutando consulta de disponibilidad: " . $stmt->error);
            return false;
        }
        
        $row = $result->fetch_assoc();
        $disponible = $row['total'] == 0;
        
        error_log("Habitación " . $this->idHabitacion . " disponible: " . ($disponible ? "SÍ" : "NO"));
        
        return $disponible;
    }

    // Método adicional para consultar reservaciones por huésped
    public function consultarPorHuesped($idHuesped){
        return $this->consultar("r.idHuesped = '" . $idHuesped . "'");
    }

    // Método adicional para consultar reservaciones por habitación
    public function consultarPorHabitacion($idHabitacion){
        return $this->consultar("r.idHabitacion = '" . $idHabitacion . "'");
    }

    // Método para verificar si una reservación existe
    public function existe($idReservacion){
        $reservaciones = $this->consultar("r.idReservacion = " . $idReservacion);
        return count($reservaciones) > 0;
    }
}
?>
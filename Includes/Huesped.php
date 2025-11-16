<?php
require_once('Conexion.php');
class Huesped{
    public $idHuesped;
    public $nombre;
    public $telefono;
    public $email;
    public $documento;
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }

    public function insertar(){
        $ins = $this->conexion->enlace->prepare('INSERT INTO huespedes VALUES(?,?,?,?,?)');
        $ins->bind_param('sssss', $this->idHuesped, $this->nombre, $this->telefono, $this->email, $this->documento);
        $res = $ins->execute();
        return $res>0;
    }

    public function actualizar(){
        $ins = $this->conexion->enlace->prepare('UPDATE huespedes SET nombre=?, telefono=?, email=?, documento=? WHERE idHuesped=?');
        $ins->bind_param('sssss', $this->nombre, $this->telefono, $this->email, $this->documento, $this->idHuesped);
        $res = $ins->execute();
        return $res>0;
    }

    public function eliminar(){
        $ins = $this->conexion->enlace->prepare('DELETE FROM huespedes WHERE idHuesped=?');
        $ins->bind_param('s', $this->idHuesped);
        $res = $ins->execute();
        return $res>0;
    }
    
    public function consultar($condicion=null){
        // Construir consulta SQL segura
        $sql = "SELECT * FROM huespedes";
        
        if($condicion != null && trim($condicion) != ''){
            // Si la condición no empieza con WHERE, agregarlo
            if(stripos(trim($condicion), 'WHERE') !== 0){
                $sql .= " WHERE " . $condicion;
            } else {
                $sql .= " " . $condicion;
            }
        }
        
        error_log("Ejecutando consulta Huesped: " . $sql);
        
        $result = mysqli_query($this->conexion->enlace, $sql);
        
        // VERIFICAR SI LA CONSULTA FUE EXITOSA
        if (!$result) {
            error_log("Error en consulta SQL Huesped: " . mysqli_error($this->conexion->enlace));
            return array();
        }
        
        $huespedes = array();
        
        if ($result->num_rows > 0) {
            while($fila = $result->fetch_array(MYSQLI_ASSOC)){
                $h = new Huesped();
                $h->idHuesped = $fila['idHuesped'];
                $h->nombre = $fila['nombre'];
                $h->telefono = $fila['telefono'];
                $h->email = $fila['email'];
                $h->documento = $fila['documento'];
                $huespedes[] = $h;
            }
        }
        
        return $huespedes;
    }
}
?>
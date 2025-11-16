<?php
require_once('Conexion.php');
class Habitacion{
    public $idHabitacion;
    public $tipo;
    public $capacidad;
    public $precio;
    public $descripcion;
    public $estado;
    public $imagen;
    private $conexion;

    public function insertar(){
        $this->conectar();
        $ins = $this->conexion->enlace->prepare('INSERT INTO habitaciones (idHabitacion, tipo, capacidad, precio, descripcion, estado, imagen) VALUES(?,?,?,?,?,?,?)');
        $ins->bind_param('ssidsss', 
            $this->idHabitacion, 
            $this->tipo, 
            $this->capacidad, 
            $this->precio, 
            $this->descripcion, 
            $this->estado,
            $this->imagen
        );
        $res = $ins->execute();
        return $res>0;
    }

    public function actualizar(){
        $this->conectar();
        $ins = $this->conexion->enlace->prepare('UPDATE habitaciones SET tipo=?, capacidad=?, precio=?, descripcion=?, estado=?, imagen=? WHERE idHabitacion=?');
        $ins->bind_param('sidssss',
            $this->tipo,
            $this->capacidad,
            $this->precio,
            $this->descripcion,
            $this->estado,
            $this->imagen,
            $this->idHabitacion
        );
        $res = $ins->execute();
        return $res>0;
    }

    public function eliminar(){
        $this->conectar();
        if ($this->imagen != "default.jpg" && file_exists("../imagenes/habitaciones/" . $this->imagen)) {
            unlink("../imagenes/habitaciones/" . $this->imagen);
        }
        
        $ins = $this->conexion->enlace->prepare('DELETE FROM habitaciones WHERE idHabitacion=?');
        $ins->bind_param('s', $this->idHabitacion);
        $res = $ins->execute();
        return $res>0;
    }

    public function consultar($condicion=null){
        $this->conectar();
        $condicion = $condicion!=null ? ' WHERE '.$condicion : '';
        $query = "SELECT * FROM habitaciones".$condicion;
        $result = mysqli_query($this->conexion->enlace, $query);
        
        $habitaciones = [];
        while($fila = $result->fetch_assoc()){
            $h = new Habitacion();
            $h->idHabitacion = $fila['idHabitacion'];
            $h->tipo = $fila['tipo'];
            $h->capacidad = (int)$fila['capacidad'];
            $h->precio = (float)$fila['precio'];
            $h->descripcion = $fila['descripcion'] ?? 'N/A';
            $h->estado = $fila['estado'];
            $h->imagen = $fila['imagen'] ?? 'default.jpg';
            $habitaciones[] = $h;
        }
        $result->close();
        return $habitaciones;
    }

    private function conectar(){
        if($this->conexion == null){
            $this->conexion = new Conexion();
            if($this->conexion->enlace == null){
                $this->conexion->conectar();
            }
        }
    }

    function __construct(){
        $this->idHabitacion = '';
        $this->tipo = '';
        $this->capacidad = 1;
        $this->precio = 0.0;
        $this->descripcion = '';
        $this->estado = 'Disponible';
        $this->imagen = 'default.jpg';
        $this->conexion = null;
        $this->conectar();
    }
}
?>
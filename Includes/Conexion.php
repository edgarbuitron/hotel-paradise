<?php
class Conexion{

    private $servidor="127.0.0.1";
    private $usuario="root";
    private $pass="root";
    private $bd="hotel";

    public $enlace;

    public function conectar(){
        $this->enlace = mysqli_connect($this->servidor,$this->usuario,$this->pass,$this->bd);
        if(mysqli_connect_errno()){
            die('Ocurrio un error en la conexion: ' + mysqli_connect_errno());
        }
    }

}
?>
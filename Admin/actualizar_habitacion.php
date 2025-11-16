<?php
if(isset($_POST['idHabitacion']) && isset($_POST['tipo']) && isset($_POST['capacidad']) 
    && isset($_POST['precio']) && isset($_POST['estado'])){
    
    require_once('../includes/Habitacion.php');
    $h = new Habitacion();
    $h->idHabitacion = $_POST['idHabitacion'];
    $h->tipo = $_POST['tipo'];
    $h->capacidad = $_POST['capacidad'];
    $h->precio = $_POST['precio'];
    $h->estado = $_POST['estado'];
    $h->descripcion = $_POST['descripcion'];
    
    $res = $h->actualizar();
    
    if($res){
        header('Location: consulta_habitaciones.php?m=1');
    } else {
        header('Location: consulta_habitaciones.php?m=0');
    }
} else {
    header('Location: consulta_habitaciones.php');
}
?>
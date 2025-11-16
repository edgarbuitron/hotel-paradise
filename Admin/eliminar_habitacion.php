<?php
if(isset($_POST['idHabitacion'])){
    require_once('../includes/Habitacion.php');
    $h = new Habitacion();
    $h->idHabitacion = $_POST['idHabitacion'];
    $res = $h->eliminar();
    
    if($res){
        header('Location: consulta_habitaciones.php?m=2');
    } else {
        header('Location: consulta_habitaciones.php?m=3');
    }
} else {
    header('Location: consulta_habitaciones.php');
}
?>
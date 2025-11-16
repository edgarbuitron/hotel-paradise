<?php
if(isset($_POST['idReservacion']) && isset($_POST['idHabitacion']) && isset($_POST['idHuesped']) 
    && isset($_POST['fechaEntrada']) && isset($_POST['fechaSalida']) && isset($_POST['estado'])){
    
    require_once('../includes/Reservacion.php');
    $r = new Reservacion();
    $r->idReservacion = $_POST['idReservacion'];
    $r->idHabitacion = $_POST['idHabitacion'];
    $r->idHuesped = $_POST['idHuesped'];
    $r->fechaEntrada = $_POST['fechaEntrada'];
    $r->fechaSalida = $_POST['fechaSalida'];
    $r->estado = $_POST['estado'];
    
    $res = $r->actualizar();
    
    if($res){
        header('Location: consulta_reservaciones.php?m=1');
    } else {
        header('Location: consulta_reservaciones.php?m=0');
    }
} else {
    header('Location: consulta_reservaciones.php');
}
?>
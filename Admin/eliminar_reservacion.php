<?php
if(isset($_POST['idReservacion'])){
    require_once('../includes/Reservacion.php');
    $r = new Reservacion();
    $r->idReservacion = $_POST['idReservacion'];
    $res = $r->eliminar();
    
    if($res){
        header('Location: consulta_reservaciones.php?m=2');
    } else {
        header('Location: consulta_reservaciones.php?m=3');
    }
} else {
    header('Location: consulta_reservaciones.php');
}
?>
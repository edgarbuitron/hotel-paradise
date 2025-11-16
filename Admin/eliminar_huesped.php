<?php
if(isset($_POST['idHuesped'])){
    require_once('../includes/Huesped.php');
    $h = new Huesped();
    $h->idHuesped = $_POST['idHuesped'];
    $res = $h->eliminar();
    
    if($res){
        header('Location: consulta_huespedes.php?m=2');
    } else {
        header('Location: consulta_huespedes.php?m=3');
    }
} else {
    header('Location: consulta_huespedes.php');
}
?>
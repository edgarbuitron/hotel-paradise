<?php
if (!empty($_POST['correo']) && !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
    header('Location: consulta_huespedes.php?m=2'); // Código para email inválido
    exit;
}
if(isset($_POST['idHuesped']) && isset($_POST['nombre']) && isset($_POST['telefono']) 
    && isset($_POST['documento'])){
    
    require_once('../includes/Huesped.php');
    $h = new Huesped();
    $h->idHuesped = $_POST['idHuesped'];
    $h->nombre = $_POST['nombre'];
    $h->telefono = $_POST['telefono'] ?? '';
    $h->email = $_POST['correo'] ?? '';
    $h->documento = $_POST['documento'];
    
    $res = $h->actualizar();
    
    if($res){
        header('Location: consulta_huespedes.php?m=1');
    } else {
        header('Location: consulta_huespedes.php?m=0');
    }
} else {
    header('Location: consulta_huespedes.php');
}
?>
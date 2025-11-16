<?php
// Verificar si la función ya existe antes de declararla
if (!function_exists('verificarAutenticacion')) {
    function verificarAutenticacion() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true){
            header('Location: login.php');
            exit();
        }
    }
}

if (!function_exists('cerrarSesion')) {
    function cerrarSesion() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: login.php');
        exit();
    }
}

// Iniciar sesión solo si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar timeout de sesión (1 hora)
if(isset($_SESSION['timeout']) && time() > $_SESSION['timeout']) {
    cerrarSesion();
}

// Actualizar timeout en cada solicitud
if(isset($_SESSION['admin_logueado']) && $_SESSION['admin_logueado'] === true){
    $_SESSION['timeout'] = time() + 3600; // 1 hora
}

// Verificar si se solicita logout
if(isset($_GET['logout'])) {
    cerrarSesion();
}
?>
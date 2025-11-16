<?php
// Agregar esto como PRIMERA línea
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-umbrella-beach me-2"></i>Hotel Paradise Cancún
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPublic">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="habitaciones.php">
                        <i class="fas fa-bed me-1"></i>Habitaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servicios.php">
                        <i class="fas fa-spa me-1"></i>Servicios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-reservar" href="reservar.php">
                        <i class="fas fa-calendar-check me-1"></i>Reservar Ahora
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="../admin/login.php">
                        <i class="fas fa-lock me-1"></i>Administración
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
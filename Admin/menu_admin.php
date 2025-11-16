<?php include('seguridad.php'); verificarAutenticacion(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="fas fa-hotel me-2"></i>Admin Paradise
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bed me-1"></i> Habitaciones
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="registro_habitacion.php">
                            <i class="fas fa-plus-circle me-1 text-success"></i> Nueva Habitación
                        </a></li>
                        <li><a class="dropdown-item" href="consulta_habitaciones.php">
                            <i class="fas fa-list me-1 text-info"></i> Gestionar Habitaciones
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> Huéspedes
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="registro_huesped.php">
                            <i class="fas fa-user-plus me-1 text-success"></i> Nuevo Huésped
                        </a></li>
                        <li><a class="dropdown-item" href="consulta_huespedes.php">
                            <i class="fas fa-address-book me-1 text-info"></i> Gestionar Huéspedes
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-check me-1"></i> Reservaciones
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="registro_reservacion.php">
                            <i class="fas fa-plus me-1 text-success"></i> Nueva Reservación
                        </a></li>
                        <li><a class="dropdown-item" href="consulta_reservaciones.php">
                            <i class="fas fa-tasks me-1 text-info"></i> Gestionar Reservaciones
                        </a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="navbar-text text-light me-3">
                        <i class="fas fa-user-circle me-1"></i><?php echo $_SESSION['usuario']; ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-semibold" href="?logout=true">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
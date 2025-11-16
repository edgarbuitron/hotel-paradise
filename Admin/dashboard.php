
<?php include('seguridad.php'); verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel Paradise</title>
    <?php include('../includes/cabecera.php'); ?>
    
</head>
<body>
    <?php include('menu_admin.php'); ?>
    
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-primary">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </h1>
                        <p class="text-muted mb-0">Panel de control del Hotel Paradise Cancún</p>
                    </div>
                    <div class="text-end">
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo date('d/m/Y'); ?>
                        </p>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>
                            Bienvenido, <?php echo $_SESSION['usuario']; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="row">
            <!-- Total Habitaciones -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">
                                    <?php 
                                    require_once('../includes/Habitacion.php');
                                    $h = new Habitacion();
                                    $habitaciones = $h->consultar();
                                    echo is_array($habitaciones) ? count($habitaciones) : 0;
                                    ?>
                                </h2>
                                <p class="mb-0 opacity-90">Total Habitaciones</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-bed fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Huéspedes Registrados -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 bg-success bg-gradient text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">
                                    <?php 
                                    require_once('../includes/Huesped.php');
                                    $huesped = new Huesped();
                                    $huespedes = $huesped->consultar();
                                    echo is_array($huespedes) ? count($huespedes) : 0;
                                    ?>
                                </h2>
                                <p class="mb-0 opacity-90">Huéspedes Registrados</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reservaciones Activas -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 bg-warning bg-gradient text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">
                                    <?php 
                                    require_once('../includes/Reservacion.php');
                                    $r = new Reservacion();
                                    $reservacionesActivas = $r->consultar("r.estado='Confirmada'");
                                    echo is_array($reservacionesActivas) ? count($reservacionesActivas) : 0;
                                    ?>
                                </h2>
                                <p class="mb-0 opacity-90">Reservaciones Activas</p>
                            </div>
                            <div class="bg-dark bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ingresos Mensuales -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 bg-info bg-gradient text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">
                                    $<?php 
                                    $total = 0;
                                    if (is_array($reservacionesActivas)) {
                                        foreach($reservacionesActivas as $res) {
                                            $habitacionTemp = new Habitacion();
                                            $habitacionesTemp = $habitacionTemp->consultar("idHabitacion='".$res->idHabitacion."'");
                                            if(count($habitacionesTemp) > 0) {
                                                $total += $habitacionesTemp[0]->precio;
                                            }
                                        }
                                    }
                                    echo number_format($total, 2);
                                    ?>
                                </h2>
                                <p class="mb-0 opacity-90">Ingresos Mensuales</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <a href="registro_habitacion.php" class="card text-decoration-none h-100 border-primary hover-shadow">
                                    <div class="card-body text-center text-primary">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-plus-circle fa-2x"></i>
                                        </div>
                                        <h6 class="fw-bold">Nueva Habitación</h6>
                                        <small class="text-muted">Agregar nueva habitación al sistema</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <a href="registro_huesped.php" class="card text-decoration-none h-100 border-success hover-shadow">
                                    <div class="card-body text-center text-success">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                        </div>
                                        <h6 class="fw-bold">Nuevo Huésped</h6>
                                        <small class="text-muted">Registrar nuevo huésped</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <a href="registro_reservacion.php" class="card text-decoration-none h-100 border-warning hover-shadow">
                                    <div class="card-body text-center text-warning">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-calendar-plus fa-2x"></i>
                                        </div>
                                        <h6 class="fw-bold">Nueva Reservación</h6>
                                        <small class="text-muted">Crear nueva reservación</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <a href="consulta_reservaciones.php" class="card text-decoration-none h-100 border-info hover-shadow">
                                    <div class="card-body text-center text-info">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-search fa-2x"></i>
                                        </div>
                                        <h6 class="fw-bold">Ver Reservaciones</h6>
                                        <small class="text-muted">Gestionar reservaciones existentes</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimas Reservaciones y Estadísticas -->
        <div class="row">
            <!-- Últimas Reservaciones -->
            <div class="col-xl-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Últimas Reservaciones
                        </h5>
                        <a href="consulta_reservaciones.php" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Huésped</th>
                                        <th>Habitación</th>
                                        <th>Entrada</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ultimasReservaciones = $r->consultar("1 ORDER BY r.idReservacion DESC LIMIT 5");
                                    if (is_array($ultimasReservaciones) && count($ultimasReservaciones) > 0) {
                                        foreach($ultimasReservaciones as $res): 
                                            $badgeClass = [
                                                'Confirmada' => 'bg-success',
                                                'Pendiente' => 'bg-warning',
                                                'Cancelada' => 'bg-danger',
                                                'Finalizada' => 'bg-secondary'
                                            ][$res->estado] ?? 'bg-primary';
                                    ?>
                                    <tr>
                                        <td class="fw-bold">#<?php echo $res->idReservacion; ?></td>
                                        <td><?php echo htmlspecialchars($res->nombreHuesped); ?></td>
                                        <td><?php echo htmlspecialchars($res->tipoHabitacion); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($res->fechaEntrada)); ?></td>
                                        <td>
                                            <span class="badge <?php echo $badgeClass; ?>">
                                                <?php echo htmlspecialchars($res->estado); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="editar_reservacion.php?id=<?php echo $res->idReservacion; ?>" 
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                            No hay reservaciones registradas
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de Estado -->
            <div class="col-xl-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Estadísticas de Habitaciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $habitacionesDisponibles = $h->consultar("estado='Disponible'");
                        $habitacionesOcupadas = $h->consultar("estado='Ocupada'");
                        $habitacionesMantenimiento = $h->consultar("estado='Mantenimiento'");
                        
                        $disponibles = is_array($habitacionesDisponibles) ? count($habitacionesDisponibles) : 0;
                        $ocupadas = is_array($habitacionesOcupadas) ? count($habitacionesOcupadas) : 0;
                        $mantenimiento = is_array($habitacionesMantenimiento) ? count($habitacionesMantenimiento) : 0;
                        $total = $disponibles + $ocupadas + $mantenimiento;
                        ?>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">Disponibles</span>
                                <span class="badge bg-success"><?php echo $disponibles; ?></span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: <?php echo $total > 0 ? ($disponibles/$total)*100 : 0; ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">Ocupadas</span>
                                <span class="badge bg-warning"><?php echo $ocupadas; ?></span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: <?php echo $total > 0 ? ($ocupadas/$total)*100 : 0; ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">Mantenimiento</span>
                                <span class="badge bg-danger"><?php echo $mantenimiento; ?></span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-danger" style="width: <?php echo $total > 0 ? ($mantenimiento/$total)*100 : 0; ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <div class="bg-light p-3 rounded">
                                <h4 class="text-primary mb-1"><?php echo $total; ?></h4>
                                <small class="text-muted">Total Habitaciones</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Efecto hover para las tarjetas de acción
        document.addEventListener('DOMContentLoaded', function() {
            const actionCards = document.querySelectorAll('.hover-shadow');
            actionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'all 0.3s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
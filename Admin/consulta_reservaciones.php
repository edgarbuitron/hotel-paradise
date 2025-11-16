<?php include('seguridad.php'); verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reservaciones - Hotel Paradise</title>
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
                        <h1 class="h3 fw-bold text-primary mb-1">
                            <i class="fas fa-calendar-check me-2"></i>Gestionar Reservaciones
                        </h1>
                        <p class="text-muted mb-0">Administre todas las reservaciones del hotel</p>
                    </div>
                    <a href="registro_reservacion.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nueva Reservación
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Estado -->
        <div class="row mb-4">
            <?php
            require_once('../includes/Reservacion.php');
            $r = new Reservacion();
            
            $estados = [
                'Confirmada' => ['bg-success', 'fas fa-check-circle'],
                'Pendiente' => ['bg-warning', 'fas fa-clock'],
                'Cancelada' => ['bg-danger', 'fas fa-times-circle'],
                'Finalizada' => ['bg-secondary', 'fas fa-flag-checkered']
            ];
            
            foreach($estados as $estado => $clases):
                $reservacionesEstado = $r->consultar("r.estado = '$estado'");
                $count = is_array($reservacionesEstado) ? count($reservacionesEstado) : 0;
            ?>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0 text-<?php echo explode(' ', $clases[0])[1]; ?>"><?php echo $count; ?></h3>
                                <small class="text-muted"><?php echo $estado; ?></small>
                            </div>
                            <div class="<?php echo $clases[0]; ?> text-white rounded-circle p-3">
                                <i class="<?php echo $clases[1]; ?> fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Filtros Avanzados -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="consulta_reservaciones.php" method="get" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Huésped</label>
                                <input type="text" name="busqueda" class="form-control" 
                                       placeholder="Nombre del huésped..."
                                       value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="">Todos</option>
                                    <?php foreach($estados as $estado => $clases): ?>
                                    <option value="<?php echo $estado; ?>" 
                                        <?php echo (isset($_GET['estado']) && $_GET['estado'] == $estado) ? 'selected' : ''; ?>>
                                        <?php echo $estado; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" 
                                       value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : ''; ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" 
                                       value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i>Aplicar Filtros
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Reservaciones -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Lista de Reservaciones
                        </h5>
                        <span class="badge bg-primary">
                            <?php
                            $condicion = construirCondicion();
                            $reservaciones = $r->consultar($condicion);
                            echo count($reservaciones) . ' reservaciones';
                            ?>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4"># Reservación</th>
                                        <th>Huésped</th>
                                        <th>Habitación</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Estado</th>
                                        <th class="text-center pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($reservaciones) > 0) {
                                        foreach($reservaciones as $res): 
                                            $badgeClass = [
                                                'Confirmada' => 'bg-success',
                                                'Pendiente' => 'bg-warning',
                                                'Cancelada' => 'bg-danger',
                                                'Finalizada' => 'bg-secondary'
                                            ][$res->estado] ?? 'bg-primary';
                                            
                                            $hoy = new DateTime();
                                            $checkin = new DateTime($res->fechaEntrada);
                                            $diasFaltantes = $hoy->diff($checkin)->days;
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold">#<?php echo $res->idReservacion; ?></td>
                                        <td>
                                            <div class="fw-semibold"><?php echo $res->nombreHuesped; ?></div>
                                            <small class="text-muted">ID: <?php echo $res->idHuesped; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <?php echo $res->tipoHabitacion; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?php echo date('d/m/Y', strtotime($res->fechaEntrada)); ?></div>
                                            <?php if($checkin > $hoy): ?>
                                            <small class="text-info">
                                                <i class="fas fa-clock me-1"></i>En <?php echo $diasFaltantes; ?> días
                                            </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?php echo date('d/m/Y', strtotime($res->fechaSalida)); ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $badgeClass; ?>">
                                                <?php echo $res->estado; ?>
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="editar_reservacion.php?id=<?php echo $res->idReservacion; ?>" 
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="confirmarEliminacion('<?php echo $res->idReservacion; ?>')"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    } else { ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i>
                                                <h5 class="fw-semibold">No se encontraron reservaciones</h5>
                                                <p class="mb-0">No hay registros que coincidan con los criterios de búsqueda</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(idReservacion){
            bootbox.confirm({
                title: '<i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirmar Eliminación',
                message: '<p>¿Está seguro que desea eliminar la reservación <strong>#' + idReservacion + '</strong>?</p><small class="text-muted">Esta acción no se puede deshacer y liberará la habitación asociada.</small>',
                buttons: {
                    confirm: {
                        label: '<i class="fas fa-trash me-1"></i>Eliminar',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: '<i class="fas fa-times me-1"></i>Cancelar',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if(result){
                        let formulario = document.createElement('form');
                        formulario.action = "eliminar_reservacion.php";
                        formulario.method = "post";
                        let id = document.createElement('input');
                        id.name = "idReservacion";
                        id.value = idReservacion;
                        id.type = "hidden";
                        formulario.appendChild(id);
                        document.body.appendChild(formulario);
                        formulario.submit();
                    }
                }
            });
        }
    </script>
</body>
</html>

<?php
function construirCondicion() {
    $condiciones = [];
    
    if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
        $busqueda = $_GET['busqueda'];
        $condiciones[] = "h.nombre LIKE '%$busqueda%'";
    }
    
    if(isset($_GET['estado']) && !empty($_GET['estado'])){
        $estado = $_GET['estado'];
        $condiciones[] = "r.estado = '$estado'";
    }
    
    if(isset($_GET['fecha_inicio']) && !empty($_GET['fecha_inicio'])){
        $fecha_inicio = $_GET['fecha_inicio'];
        $condiciones[] = "r.fechaEntrada >= '$fecha_inicio'";
    }
    
    if(isset($_GET['fecha_fin']) && !empty($_GET['fecha_fin'])){
        $fecha_fin = $_GET['fecha_fin'];
        $condiciones[] = "r.fechaSalida <= '$fecha_fin'";
    }
    
    return count($condiciones) > 0 ? implode(' AND ', $condiciones) : "1 ORDER BY r.fechaEntrada DESC";
}
?>
<?php include('seguridad.php'); 
verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Habitaciones - Hotel Paradise</title>
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
                            <i class="fas fa-bed me-2"></i>Gestionar Habitaciones
                        </h1>
                        <p class="text-muted mb-0">Administre todas las habitaciones del hotel</p>
                    </div>
                    <a href="registro_habitacion.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i>Nueva Habitación
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="consulta_habitaciones.php" method="get" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Búsqueda</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="busqueda" class="form-control" 
                                           placeholder="Buscar por tipo o estado..." 
                                           value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="Disponible" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                                    <option value="Ocupada" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Ocupada') ? 'selected' : ''; ?>>Ocupada</option>
                                    <option value="Mantenimiento" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipo</label>
                                <select name="tipo" class="form-select">
                                    <option value="">Todos los tipos</option>
                                    <option value="Individual" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Individual') ? 'selected' : ''; ?>>Individual</option>
                                    <option value="Doble" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Doble') ? 'selected' : ''; ?>>Doble</option>
                                    <option value="Suite" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Suite') ? 'selected' : ''; ?>>Suite</option>
                                    <option value="Familiar" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Familiar') ? 'selected' : ''; ?>>Familiar</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i>Filtrar
                                </button>
                            </div>
                        </form>
                        
                        <?php if(isset($_GET['busqueda']) || isset($_GET['estado']) || isset($_GET['tipo'])): ?>
                        <div class="mt-3">
                            <a href="consulta_habitaciones.php" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Limpiar filtros
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Habitaciones -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Lista de Habitaciones
                        </h5>
                        <span class="badge bg-primary">
                            <?php
                            require_once('../includes/Habitacion.php');
                            $h = new Habitacion();
                            $condicion = construirCondicion();
                            $habitaciones = $h->consultar($condicion);
                            echo count($habitaciones) . ' registros';
                            ?>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID Habitación</th>
                                        <th>Tipo</th>
                                        <th>Capacidad</th>
                                        <th>Precio</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th class="text-center pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($habitaciones) > 0) {
                                        foreach($habitaciones as $hab): 
                                            $badgeClass = [
                                                'Disponible' => 'bg-success',
                                                'Ocupada' => 'bg-warning',
                                                'Mantenimiento' => 'bg-danger'
                                            ][$hab->estado] ?? 'bg-secondary';
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo $hab->idHabitacion; ?></td>
                                        <td>
                                            <span class="fw-semibold"><?php echo $hab->tipo; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-users me-1"></i><?php echo $hab->capacidad; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">$<?php echo number_format($hab->precio, 2); ?></span>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo $hab->descripcion ?? 'Sin descripción'; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $badgeClass; ?>">
                                                <?php echo $hab->estado; ?>
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="editar_habitacion.php?id=<?php echo $hab->idHabitacion; ?>" 
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="confirmarEliminacion('<?php echo $hab->idHabitacion; ?>')"
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
                                                <i class="fas fa-bed fa-3x mb-3 opacity-50"></i>
                                                <h5 class="fw-semibold">No se encontraron habitaciones</h5>
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

    <!-- Mensajes de confirmación -->
    <?php if(isset($_GET['m'])): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast show" role="alert">
            <div class="toast-header <?php echo $_GET['m'] == '1' || $_GET['m'] == '2' ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
                <i class="fas <?php echo $_GET['m'] == '1' || $_GET['m'] == '2' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
                <strong class="me-auto">
                    <?php echo $_GET['m'] == '1' || $_GET['m'] == '2' ? 'Éxito' : 'Error'; ?>
                </strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <?php
                $mensajes = [
                    '0' => 'Error al actualizar la habitación',
                    '1' => 'Habitación actualizada correctamente',
                    '2' => 'Habitación eliminada correctamente',
                    '3' => 'Error al eliminar la habitación'
                ];
                echo $mensajes[$_GET['m']] ?? 'Operación completada';
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function confirmarEliminacion(idHabitacion){
            bootbox.confirm({
                title: '<i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirmar Eliminación',
                message: '<p>¿Está seguro que desea eliminar la habitación <strong>' + idHabitacion + '</strong>?</p><small class="text-muted">Esta acción no se puede deshacer.</small>',
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
                        formulario.action = "eliminar_habitacion.php";
                        formulario.method = "post";
                        let id = document.createElement('input');
                        id.name = "idHabitacion";
                        id.value = idHabitacion;
                        id.type = "hidden";
                        formulario.appendChild(id);
                        document.body.appendChild(formulario);
                        formulario.submit();
                    }
                }
            });
        }

        // Auto-ocultar toasts después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    var bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
</body>
</html>

<?php
function construirCondicion() {
    $condiciones = [];
    
    if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
        $busqueda = $_GET['busqueda'];
        $condiciones[] = "(tipo LIKE '%$busqueda%' OR estado LIKE '%$busqueda%' OR idHabitacion LIKE '%$busqueda%')";
    }
    
    if(isset($_GET['estado']) && !empty($_GET['estado'])){
        $estado = $_GET['estado'];
        $condiciones[] = "estado = '$estado'";
    }
    
    if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
        $tipo = $_GET['tipo'];
        $condiciones[] = "tipo = '$tipo'";
    }
    
    return count($condiciones) > 0 ? implode(' AND ', $condiciones) : null;
}
?>
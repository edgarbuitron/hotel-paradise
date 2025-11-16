<?php include('seguridad.php'); verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Huéspedes - Hotel Paradise</title>
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
                            <i class="fas fa-users me-2"></i>Gestionar Huéspedes
                        </h1>
                        <p class="text-muted mb-0">Administre todos los huéspedes registrados</p>
                    </div>
                    <a href="registro_huesped.php" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i>Nuevo Huésped
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="consulta_huespedes.php" method="get" class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Búsqueda</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="busqueda" class="form-control" 
                                           placeholder="Buscar por nombre o documento..." 
                                           value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Ordenar por</label>
                                <select name="orden" class="form-select">
                                    <option value="nombre ASC">Nombre A-Z</option>
                                    <option value="nombre DESC">Nombre Z-A</option>
                                    <option value="idHuesped DESC">Más recientes</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i>Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary bg-gradient text-white border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">
                                    <?php
                                    require_once('../includes/Huesped.php');
                                    $h = new Huesped();
                                    $huespedes = $h->consultar();
                                    echo count($huespedes);
                                    ?>
                                </h3>
                                <small>Total Huéspedes</small>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Huéspedes -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-book me-2"></i>Lista de Huéspedes
                        </h5>
                        <span class="badge bg-primary"><?php echo count($huespedes); ?> registros</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID Huésped</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Documento</th>
                                        <th class="text-center pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Construir condición para la consulta
                                $condicion = "1"; // Siempre verdadero para mostrar todos
                                if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
                                    // Sanitizar entrada básica para evitar romper la consulta
                                    $busqueda = addslashes($_GET['busqueda']);
                                    $condicion = "nombre LIKE '%$busqueda%' OR documento LIKE '%$busqueda%'";
                                }

                                $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre ASC';
                                // Validar orden (whitelist) para evitar inyección SQL en ORDER BY
                                $allowedOrders = ['nombre ASC', 'nombre DESC', 'idHuesped DESC'];
                                if(!in_array($orden, $allowedOrders)){
                                    $orden = 'nombre ASC';
                                }

                                $huespedes = $h->consultar($condicion . " ORDER BY " . $orden);

                                if(count($huespedes) > 0) {
                                    foreach($huespedes as $hue): 
                                ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo $hue->idHuesped; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold"><?php echo $hue->nombre; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($hue->telefono): ?>
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-phone me-1"></i><?php echo $hue->telefono; ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="text-muted">No especificado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($hue->email): ?>
                                            <a href="mailto:<?php echo $hue->email; ?>" class="text-decoration-none">
                                                <i class="fas fa-envelope me-1 text-muted"></i>
                                                <?php echo $hue->email; ?>
                                            </a>
                                            <?php else: ?>
                                            <span class="text-muted">No especificado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded"><?php echo $hue->documento; ?></code>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="editar_huesped.php?id=<?php echo $hue->idHuesped; ?>" 
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="confirmarEliminacion('<?php echo $hue->idHuesped; ?>')"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                                <h5 class="fw-semibold">No se encontraron huéspedes</h5>
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
                    '0' => 'Error al actualizar el huésped',
                    '1' => 'Huésped actualizado correctamente',
                    '2' => 'Huésped eliminado correctamente',
                    '3' => 'Error al eliminar el huésped'
                ];
                echo $mensajes[$_GET['m']] ?? 'Operación completada';
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function confirmarEliminacion(idHuesped){
            bootbox.confirm({
                title: '<i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirmar Eliminación',
                message: '<p>¿Está seguro que desea eliminar este huésped?</p><small class="text-muted">Esta acción eliminará permanentemente todos los datos del huésped.</small>',
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
                        formulario.action = "eliminar_huesped.php";
                        formulario.method = "post";
                        let id = document.createElement('input');
                        id.name = "idHuesped";
                        id.value = idHuesped;
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
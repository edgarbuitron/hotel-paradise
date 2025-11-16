<?php
require_once('../includes/Habitacion.php');
$h = new Habitacion();

// Obtener datos de la habitación a editar
if(isset($_GET['id'])){
    $habitacion = $h->consultar("idHabitacion = '".$_GET['id']."'");
    if(count($habitacion) > 0){
        $habitacion = $habitacion[0];
    } else {
        header('Location: consulta_habitaciones.php');
        exit();
    }
} else {
    header('Location: consulta_habitaciones.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Habitación</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card admin-form">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Habitación</h4>
                    </div>
                    <div class="card-body">
                        <form action="actualizar_habitacion.php" method="post" onsubmit="return validarFormulario()">
                            <div class="mb-3">
                                <label for="idHabitacion" class="form-label">ID Habitación:</label>
                                <input type="text" name="idHabitacion" id="idHabitacion" class="form-control" 
                                       value="<?php echo $habitacion->idHabitacion; ?>" readonly>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label">Tipo:</label>
                                        <select name="tipo" id="tipo" class="form-select" required>
                                            <option value="Individual" <?php echo $habitacion->tipo == 'Individual' ? 'selected' : ''; ?>>Individual</option>
                                            <option value="Doble" <?php echo $habitacion->tipo == 'Doble' ? 'selected' : ''; ?>>Doble</option>
                                            <option value="Suite" <?php echo $habitacion->tipo == 'Suite' ? 'selected' : ''; ?>>Suite</option>
                                            <option value="Familiar" <?php echo $habitacion->tipo == 'Familiar' ? 'selected' : ''; ?>>Familiar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="capacidad" class="form-label">Capacidad:</label>
                                        <input type="number" name="capacidad" id="capacidad" class="form-control" 
                                               min="1" max="6" value="<?php echo $habitacion->capacidad; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="2"
                                placeholder="Detalles importantes de la habitación"><?php echo $habitacion->descripcion ?? ''; ?></textarea>
                                <small class="text-muted">Ej: Vista al mar, piso alto, amenities especiales</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="precio" class="form-label">Precio por noche:</label>
                                        <input type="number" name="precio" id="precio" class="form-control" 
                                               step="0.01" min="0" value="<?php echo $habitacion->precio; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado:</label>
                                        <select name="estado" id="estado" class="form-select" required>
                                            <option value="Disponible" <?php echo $habitacion->estado == 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                                            <option value="Ocupada" <?php echo $habitacion->estado == 'Ocupada' ? 'selected' : ''; ?>>Ocupada</option>
                                            <option value="Mantenimiento" <?php echo $habitacion->estado == 'Mantenimiento' ? 'selected' : ''; ?>>Mantenimiento</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save me-1"></i>Actualizar
                                </button>
                                <a href="consulta_habitaciones.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validarFormulario() {
            const precio = document.getElementById('precio').value;
            if (precio <= 0) {
                alert('El precio debe ser mayor que cero');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
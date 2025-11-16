<?php
require_once('../includes/Reservacion.php');
require_once('../includes/Habitacion.php');
require_once('../includes/Huesped.php');

$r = new Reservacion();
$reservacion = null;

// Obtener datos de la reservación a editar
if(isset($_GET['id'])){
    $resultado = $r->consultar("r.idReservacion = ".$_GET['id']);
    if(count($resultado) > 0){
        $reservacion = $resultado[0];
    } else {
        header('Location: consulta_reservaciones.php');
        exit();
    }
} else {
    header('Location: consulta_reservaciones.php');
    exit();
}

// Obtener listas para los select
$habitacion = new Habitacion();
$habitaciones = $habitacion->consultar();

$huesped = new Huesped();
$huespedes = $huesped->consultar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Reservación</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card admin-form">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Reservación</h4>
                    </div>
                    <div class="card-body">
                        <form action="actualizar_reservacion.php" method="post" onsubmit="return validarFechas()">
                            <input type="hidden" name="idReservacion" value="<?php echo $reservacion->idReservacion; ?>">
                            
                            <div class="mb-3">
                                <label for="idHabitacion" class="form-label">Habitación:</label>
                                <select name="idHabitacion" id="idHabitacion" class="form-select" required>
                                    <?php foreach($habitaciones as $hab): ?>
                                        <option value="<?php echo $hab->idHabitacion; ?>"
                                            <?php echo $hab->idHabitacion == $reservacion->idHabitacion ? 'selected' : ''; ?>>
                                            <?php echo $hab->idHabitacion.' - '.$hab->tipo.' ($'.number_format($hab->precio,2).')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="idHuesped" class="form-label">Huésped:</label>
                                <select name="idHuesped" id="idHuesped" class="form-select" required>
                                    <?php foreach($huespedes as $hue): ?>
                                        <option value="<?php echo $hue->idHuesped; ?>"
                                            <?php echo $hue->idHuesped == $reservacion->idHuesped ? 'selected' : ''; ?>>
                                            <?php echo $hue->nombre.' ('.$hue->documento.')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaEntrada" class="form-label">Fecha de entrada:</label>
                                        <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control" 
                                               value="<?php echo $reservacion->fechaEntrada; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaSalida" class="form-label">Fecha de salida:</label>
                                        <input type="date" name="fechaSalida" id="fechaSalida" class="form-control" 
                                               value="<?php echo $reservacion->fechaSalida; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado:</label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="Confirmada" <?php echo $reservacion->estado == 'Confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                                    <option value="Pendiente" <?php echo $reservacion->estado == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="Finalizada" <?php echo $reservacion->estado == 'Finalizada' ? 'selected' : ''; ?>>Finalizada</option>
                                    <option value="Cancelada" <?php echo $reservacion->estado == 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save me-1"></i>Actualizar
                                </button>
                                <a href="consulta_reservaciones.php" class="btn btn-secondary">
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
        function validarFechas() {
            const fechaEntrada = new Date(document.getElementById('fechaEntrada').value);
            const fechaSalida = new Date(document.getElementById('fechaSalida').value);

            // Validar que la fecha de salida sea posterior a la de entrada
            if (fechaSalida <= fechaEntrada) {
                alert('La fecha de salida debe ser posterior a la fecha de entrada');
                return false;
            }

            return true;
        }

        // Establecer fecha mínima para el campo de fecha de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const fechaEntrada = document.getElementById('fechaEntrada');
            const fechaSalida = document.getElementById('fechaSalida');
            
            fechaEntrada.addEventListener('change', function() {
                fechaSalida.min = this.value;
            });
        });
    </script>
</body>
</html>
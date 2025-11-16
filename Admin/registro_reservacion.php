<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservación</title>
    <?php include('../includes/cabecera.php'); ?>
    <style>
        .datepicker {
            z-index: 9999 !important;
        }
    </style>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card admin-form">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0"><i class="fas fa-calendar-plus me-2"></i> Nueva Reservación</h4>
                        <?php
                        // Mostrar información si viene de registro de huésped
                        if(isset($_GET['huesped_id']) && isset($_GET['habitacion_id'])) {
                            require_once('../includes/Huesped.php');
                            require_once('../includes/Habitacion.php');
                            
                            $huespedObj = new Huesped();
                            $habitacionObj = new Habitacion();
                            
                            $huespedes = $huespedObj->consultar("idHuesped='".$_GET['huesped_id']."'");
                            $habitaciones = $habitacionObj->consultar("idHabitacion='".$_GET['habitacion_id']."'");
                            
                            if(count($huespedes) > 0 && count($habitaciones) > 0) {
                                $huesped = $huespedes[0];
                                $habitacion = $habitaciones[0];
                                echo '<small class="text-light">Completando reserva para: '.$huesped->nombre.' en habitación '.$habitacion->tipo.'</small>';
                            }
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <form action="registro_reservacion.php" method="post" id="formReservacion">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idHuesped" class="form-label">Huésped:</label>
                                        <select name="idHuesped" id="idHuesped" class="form-select" required>
                                            <option value="">Seleccione un huésped</option>
                                            <?php
                                                require_once('../includes/Huesped.php');
                                                $huesped = new Huesped();
                                                $huespedes = $huesped->consultar();
                                                
                                                $selectedHuesped = '';
                                                if(isset($_GET['huesped_id'])) {
                                                    $selectedHuesped = $_GET['huesped_id'];
                                                }
                                                
                                                foreach($huespedes as $h){
                                                    $selected = ($h->idHuesped == $selectedHuesped) ? 'selected' : '';
                                                    echo '<option value="'.$h->idHuesped.'" '.$selected.'>'.$h->nombre.' ('.$h->documento.')</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idHabitacion" class="form-label">Habitación:</label>
                                        <select name="idHabitacion" id="idHabitacion" class="form-select" required>
                                            <option value="">Seleccione una habitación</option>
                                            <?php
                                                require_once('../includes/Habitacion.php');
                                                $habitacion = new Habitacion();
                                                $habitaciones = $habitacion->consultar("estado='Disponible'");
                                                
                                                $selectedHabitacion = '';
                                                if(isset($_GET['habitacion_id'])) {
                                                    $selectedHabitacion = $_GET['habitacion_id'];
                                                }
                                                
                                                foreach($habitaciones as $h){
                                                    $selected = ($h->idHabitacion == $selectedHabitacion) ? 'selected' : '';
                                                    echo '<option value="'.$h->idHabitacion.'" data-precio="'.$h->precio.'" '.$selected.'>'.$h->tipo.' - '.$h->idHabitacion.' ($'.number_format($h->precio, 2).')</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaEntrada" class="form-label">Fecha de entrada:</label>
                                        <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaSalida" class="form-label">Fecha de salida:</label>
                                        <input type="date" name="fechaSalida" id="fechaSalida" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado:</label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Confirmada" selected>Confirmada</option>
                                    <option value="Cancelada">Cancelada</option>
                                    <option value="Finalizada">Finalizada</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <strong>Total estimado:</strong> <span id="total">$0.00</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save me-1"></i>Guardar Reservación
                                </button>
                                <a href="consulta_reservaciones.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancelar
                                </a>
                            </div>

                            <?php
                                if($_SERVER["REQUEST_METHOD"] == "POST" && 
                                   isset($_POST['idHuesped']) && isset($_POST['idHabitacion']) && 
                                   isset($_POST['fechaEntrada']) && isset($_POST['fechaSalida']) && 
                                   isset($_POST['estado'])){
                                        require_once('../includes/Reservacion.php');

                                        $r = new Reservacion();
                                        $r->idHuesped = $_POST['idHuesped'];
                                        $r->idHabitacion = $_POST['idHabitacion'];
                                        $r->fechaEntrada = $_POST['fechaEntrada'];
                                        $r->fechaSalida = $_POST['fechaSalida'];
                                        $r->estado = $_POST['estado'];

                                        $res = $r->insertar();

                                        if($res){
                                            echo'<div class="alert alert-success mt-3">
                                                <i class="fas fa-check-circle me-2"></i> La reservación se ha registrado satisfactoriamente 
                                            </div>';
                                            // Limpiar el formulario después de guardar exitosamente
                                            echo '<script>setTimeout(function(){ document.getElementById("formReservacion").reset(); }, 3000);</script>';
                                        }else{
                                            echo'<div class="alert alert-danger mt-3">
                                                <i class="fas fa-exclamation-circle me-2"></i> La reservación NO se ha podido registrar. Verifique las fechas y disponibilidad. 
                                            </div>';
                                        }
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function(){
            // Calcular total al cambiar fechas o habitación
            $('#idHabitacion, #fechaEntrada, #fechaSalida').change(function(){
                calcularTotal();
            });
            
            // Calcular total inmediatamente si hay valores pre-seleccionados
            setTimeout(function() {
                calcularTotal();
            }, 100);
            
            // Validar fechas al enviar el formulario
            $('#formReservacion').on('submit', function(e){
                let entrada = new Date($('#fechaEntrada').val());
                let salida = new Date($('#fechaSalida').val());
                let hoy = new Date();
                hoy.setHours(0, 0, 0, 0);
                
                if(entrada < hoy){
                    alert('La fecha de entrada no puede ser anterior al día de hoy');
                    e.preventDefault();
                    return false;
                }
                
                if(salida <= entrada){
                    alert('La fecha de salida debe ser posterior a la de entrada');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            function calcularTotal(){
                let precio = $('#idHabitacion option:selected').data('precio');
                let entrada = $('#fechaEntrada').val();
                let salida = $('#fechaSalida').val();
                
                if(precio && entrada && salida){
                    let fecha1 = new Date(entrada);
                    let fecha2 = new Date(salida);
                    let diff = fecha2 - fecha1;
                    let dias = diff / (1000 * 60 * 60 * 24);
                    
                    if(dias > 0){
                        let total = precio * dias;
                        $('#total').text('$' + total.toFixed(2) + ' MXN (' + dias + ' noches)');
                    } else {
                        $('#total').text('$0.00 MXN');
                    }
                } else {
                    $('#total').text('$0.00 MXN');
                }
            }
        });
    </script>
</body>
</html>
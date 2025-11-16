<?php
// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay datos de reserva en sesión o si se pasó un ID
$reserva_id = null;
$reserva_info = null;
$huesped_info = null;
$habitacion_info = null;

// Intentar obtener ID de reserva de diferentes fuentes
if (isset($_GET['reserva_id'])) {
    $reserva_id = intval($_GET['reserva_id']);
} elseif (isset($_SESSION['ultima_reserva_id'])) {
    $reserva_id = $_SESSION['ultima_reserva_id'];
}

error_log("=== PÁGINA DE CONFIRMACIÓN - Reserva ID: " . $reserva_id . " ===");

if ($reserva_id) {
    require_once('../includes/Reservacion.php');
    require_once('../includes/Huesped.php');
    require_once('../includes/Habitacion.php');
    
    // Obtener información de la reserva
    $reservacionObj = new Reservacion();
    $reservaciones = $reservacionObj->consultar("r.idReservacion = " . $reserva_id);
    
    if (count($reservaciones) > 0) {
        $reserva_info = $reservaciones[0];
        error_log("Reserva encontrada: " . $reserva_info->idReservacion);
        
        // Obtener información del huésped
        $huespedObj = new Huesped();
        $huespedes = $huespedObj->consultar("idHuesped = '" . $reserva_info->idHuesped . "'");
        if (count($huespedes) > 0) {
            $huesped_info = $huespedes[0];
            error_log("Huésped encontrado: " . $huesped_info->nombre);
        }
        
        // Obtener información de la habitación
        $habitacionObj = new Habitacion();
        $habitaciones = $habitacionObj->consultar("idHabitacion = '" . $reserva_info->idHabitacion . "'");
        if (count($habitaciones) > 0) {
            $habitacion_info = $habitaciones[0];
            error_log("Habitación encontrada: " . $habitacion_info->tipo);
        }
        
        // Limpiar sesión de reserva
        if (isset($_SESSION['reserva'])) {
            unset($_SESSION['reserva']);
        }
    } else {
        error_log("ERROR: No se encontró la reserva con ID: " . $reserva_id);
        header('Location: index.php');
        exit();
    }
} else {
    error_log("Redirigiendo al inicio - No hay ID de reserva");
    header('Location: index.php');
    exit();
}

// Calcular días y total
$entrada = new DateTime($reserva_info->fechaEntrada);
$salida = new DateTime($reserva_info->fechaSalida);
$dias = $entrada->diff($salida)->days;
$total_sin_impuestos = $dias * $habitacion_info->precio;
$impuestos = $total_sin_impuestos * 0.16;
$total_con_impuestos = $total_sin_impuestos + $impuestos;

error_log("Reserva calculada: " . $dias . " días, Total: $" . $total_con_impuestos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación - Hotel Paradise Cancún</title>
    <?php include('../includes/cabecera.php'); ?>
    <style>
        .confirmation-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .confirmation-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 2rem;
        }
        .success-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }
        .detail-card {
            border-left: 4px solid #28a745;
            background: #f8f9fa;
        }
        .print-btn {
            transition: all 0.3s ease;
        }
        .print-btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include('../includes/menu_publico.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card confirmation-card">
                    <div class="confirmation-header text-center">
                        <i class="fas fa-check-circle success-icon"></i>
                        <h1 class="display-5 fw-bold">¡Reserva Confirmada!</h1>
                        <p class="lead mb-0">Tu reserva ha sido procesada exitosamente. Te hemos enviado un email de confirmación.</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Información de la reserva -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card detail-card h-100">
                                    <div class="card-header bg-transparent border-0">
                                        <h5 class="card-title mb-0 text-primary">
                                            <i class="fas fa-calendar-check me-2"></i>Detalles de la Reserva
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Número de Reserva:</strong><br>
                                           <span class="fs-5 text-primary">#<?php echo str_pad($reserva_info->idReservacion, 6, '0', STR_PAD_LEFT); ?></span>
                                        </p>
                                        <p><strong>Habitación:</strong><br><?php echo $habitacion_info->tipo; ?></p>
                                        <p><strong>Check-in:</strong><br><?php echo $entrada->format('d/m/Y'); ?> (después de 3:00 PM)</p>
                                        <p><strong>Check-out:</strong><br><?php echo $salida->format('d/m/Y'); ?> (antes de 12:00 PM)</p>
                                        <p><strong>Noches:</strong><br><?php echo $dias; ?> noche(s)</p>
                                        <p><strong>Estado:</strong><br>
                                            <span class="badge bg-success fs-6"><?php echo $reserva_info->estado; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card detail-card h-100">
                                    <div class="card-header bg-transparent border-0">
                                        <h5 class="card-title mb-0 text-primary">
                                            <i class="fas fa-user me-2"></i>Información del Huésped
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nombre:</strong><br><?php echo $huesped_info->nombre; ?></p>
                                        <p><strong>Email:</strong><br><?php echo $huesped_info->email; ?></p>
                                        <p><strong>Teléfono:</strong><br><?php echo $huesped_info->telefono; ?></p>
                                        <p><strong>Documento:</strong><br><?php echo $huesped_info->documento; ?></p>
                                        <p><strong>ID Huésped:</strong><br><?php echo $huesped_info->idHuesped; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resumen de pago -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-receipt me-2"></i>Resumen de Pago
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="mb-2 fs-6"><?php echo $habitacion_info->tipo; ?> x <?php echo $dias; ?> noche(s)</p>
                                        <p class="mb-2 fs-6">Precio por noche: $<?php echo number_format($habitacion_info->precio, 2); ?></p>
                                        <p class="mb-2 fs-6">Subtotal</p>
                                        <p class="mb-2 fs-6">Impuestos (16%)</p>
                                        <hr>
                                        <p class="mb-0 fw-bold fs-5">Total a Pagar en el Hotel</p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <p class="mb-2 fs-6">$<?php echo number_format($habitacion_info->precio * $dias, 2); ?></p>
                                        <p class="mb-2 fs-6">&nbsp;</p>
                                        <p class="mb-2 fs-6">$<?php echo number_format($total_sin_impuestos, 2); ?></p>
                                        <p class="mb-2 fs-6">$<?php echo number_format($impuestos, 2); ?></p>
                                        <hr>
                                        <p class="mb-0 fw-bold fs-4 text-primary">$<?php echo number_format($total_con_impuestos, 2); ?> MXN</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información importante -->
                        <div class="alert alert-info border-0">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Información Importante para tu Estancia
                            </h6>
                            <ul class="mb-0">
                                <li>Presenta tu <strong>documento de identidad</strong> y este <strong>comprobante</strong> al check-in</li>
                                <li><strong>Check-in:</strong> a partir de las 3:00 PM</li>
                                <li><strong>Check-out:</strong> antes de las 12:00 PM</li>
                                <li>Para modificaciones o cancelaciones, contacta al hotel con tu número de reserva: <strong>#<?php echo str_pad($reserva_info->idReservacion, 6, '0', STR_PAD_LEFT); ?></strong></li>
                                <li>Te recomendamos llegar dentro de las 24 horas posteriores a tu hora de check-in programada</li>
                            </ul>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="text-center mt-4">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="index.php" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-home me-2"></i>Volver al Inicio
                                </a>
                                <a href="habitaciones.php" class="btn btn-outline-primary btn-lg px-4">
                                    <i class="fas fa-bed me-2"></i>Ver Más Habitaciones
                                </a>
                                <button onclick="window.print()" class="btn btn-outline-success btn-lg px-4 print-btn">
                                    <i class="fas fa-print me-2"></i>Imprimir Confirmación
                                </button>
                            </div>
                            <p class="text-muted mt-3">
                                <small>También puedes tomar una captura de pantalla de esta página como comprobante</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Agregar estilos para impresión
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .btn, .menu-publico {
                    display: none !important;
                }
                body {
                    background: white !important;
                }
                .card {
                    border: 2px solid #28a745 !important;
                    box-shadow: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
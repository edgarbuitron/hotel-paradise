<?php
// Esto debe ser lo PRIMERO en el archivo
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log para ver qué está pasando
error_log("=== RESERVAR.PHP ===");
error_log("Método: " . $_SERVER['REQUEST_METHOD']);
error_log("GET: " . print_r($_GET, true));
error_log("POST: " . print_r($_POST, true));

// Procesar el formulario de reserva
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['paso'])) {
    
    if($_POST['paso'] == '1') {
        error_log("Procesando PASO 1");
        // Validar datos requeridos
        $campos_requeridos = ['nombre', 'email', 'telefono', 'documento', 'habitacion_id', 'fecha_entrada', 'fecha_salida'];
        $datos_validos = true;
        
        foreach($campos_requeridos as $campo) {
            if(empty($_POST[$campo])) {
                $datos_validos = false;
                error_log("Campo requerido vacío: " . $campo);
                break;
            }
        }
        
        if($datos_validos) {
            // Paso 1: Guardar datos del huésped en sesión
            $_SESSION['reserva'] = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'telefono' => trim($_POST['telefono']),
                'documento' => trim($_POST['documento']),
                'habitacion_id' => $_POST['habitacion_id'],
                'fecha_entrada' => $_POST['fecha_entrada'],
                'fecha_salida' => $_POST['fecha_salida'],
                'adultos' => $_POST['adultos'],
                'ninos' => $_POST['ninos']
            ];
            error_log("Datos guardados en sesión. Redirigiendo a paso 2");
            header('Location: reservar.php?paso=2');
            exit();
        } else {
            $error = "Por favor, completa todos los campos requeridos.";
        }
    }
    
    if($_POST['paso'] == '2' && isset($_SESSION['reserva'])) {
        error_log("Procesando PASO 2 - Creando reserva en BD");
        // Paso 2: Procesar reserva completa
        require_once('../includes/Huesped.php');
        require_once('../includes/Reservacion.php');
        
        // Generar ID único para el huésped
        $idHuesped = 'H' . strtoupper(substr(uniqid(), -8));
        error_log("ID Huésped generado: " . $idHuesped);
        
        // Crear huésped
        $huesped = new Huesped();
        $huesped->idHuesped = $idHuesped;
        $huesped->nombre = $_SESSION['reserva']['nombre'];
        $huesped->email = $_SESSION['reserva']['email'];
        $huesped->telefono = $_SESSION['reserva']['telefono'];
        $huesped->documento = $_SESSION['reserva']['documento'];
        
        error_log("Insertando huésped: " . $huesped->nombre);
        if($huesped->insertar()) {
            error_log("Huésped insertado exitosamente - ID: " . $idHuesped);
            
            // Crear reservación
            $reservacion = new Reservacion();
            $reservacion->idHuesped = $idHuesped;
            $reservacion->idHabitacion = $_SESSION['reserva']['habitacion_id'];
            $reservacion->fechaEntrada = $_SESSION['reserva']['fecha_entrada'];
            $reservacion->fechaSalida = $_SESSION['reserva']['fecha_salida'];
            $reservacion->estado = 'Confirmada';
            
            error_log("Insertando reservación...");
            error_log("Habitación: " . $reservacion->idHabitacion);
            error_log("Entrada: " . $reservacion->fechaEntrada);
            error_log("Salida: " . $reservacion->fechaSalida);
            
            if($reservacion->insertar()) {
                error_log("RESERVA CREADA EXITOSAMENTE. ID: " . $reservacion->idReservacion);
                
                // Guardar en sesión y redirigir
                $_SESSION['ultima_reserva_id'] = $reservacion->idReservacion;
                $_SESSION['ultima_reserva_data'] = $_SESSION['reserva'];
                
                // Limpiar datos temporales
                unset($_SESSION['reserva']);
                
                error_log("Redirigiendo a confirmation.php con ID: " . $reservacion->idReservacion);
                header('Location: confirmation.php?reserva_id=' . $reservacion->idReservacion);
                exit();
            } else {
                $error = "Error al crear la reservación. La habitación no está disponible para las fechas seleccionadas.";
                error_log("ERROR al insertar reservación - Habitación no disponible");
            }
        } else {
            $error = "Error al registrar los datos del huésped. Por favor, verifica la información.";
            error_log("ERROR al insertar huésped");
        }
    }
}

// Obtener información de la habitación si se pasa por GET
$habitacion_info = null;
if(isset($_GET['habitacion_id'])) {
    require_once('../includes/Habitacion.php');
    $habitacionObj = new Habitacion();
    $habitaciones = $habitacionObj->consultar("idHabitacion='".$_GET['habitacion_id']."'");
    if(count($habitaciones) > 0) {
        $habitacion_info = $habitaciones[0];
        error_log("Habitación encontrada: " . $habitacion_info->tipo);
    } else {
        error_log("Habitación no encontrada: " . $_GET['habitacion_id']);
        header('Location: habitaciones.php');
        exit();
    }
}

// Si estamos en paso 2 pero no hay datos de reserva, redirigir al paso 1
if(isset($_GET['paso']) && $_GET['paso'] == '2' && !isset($_SESSION['reserva'])) {
    error_log("Sin datos de reserva en sesión para paso 2. Redirigiendo...");
    header('Location: reservar.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar - Hotel Paradise Cancún</title>
    <?php include('../includes/cabecera.php'); ?>
    <style>
        .reserva-progress {
            background: linear-gradient(135deg, #2c5530, #1e3a23);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .progress-step {
            text-align: center;
            padding: 0 1rem;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #d4af37;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .step-active .step-number {
            background: #ffffff;
            color: #2c5530;
        }
        .step-completed .step-number {
            background: #28a745;
        }
    </style>
</head>
<body>
    <?php include('../includes/menu_publico.php'); ?>

    <!-- Progress Bar -->
    <div class="reserva-progress">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-6 progress-step <?php echo (!isset($_GET['paso']) || $_GET['paso'] == '1') ? 'step-active' : 'step-completed'; ?>">
                            <div class="step-number">1</div>
                            <div>Datos Personales</div>
                        </div>
                        <div class="col-6 progress-step <?php echo (isset($_GET['paso']) && $_GET['paso'] == '2') ? 'step-active' : ''; ?>">
                            <div class="step-number">2</div>
                            <div>Confirmación</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, rgba(139, 115, 85, 0.8), rgba(168, 146, 122, 0.8)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">Reserva tu Estancia</h1>
                <p class="hero-subtitle">Vive la experiencia Paradise en el corazón del Caribe</p>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <?php if(isset($_GET['paso']) && $_GET['paso'] == '2' && isset($_SESSION['reserva'])): ?>
            <!-- Paso 2: Confirmación y pago -->
            <?php
            require_once('../includes/Habitacion.php');
            $habObj = new Habitacion();
            $habitaciones_list = $habObj->consultar("idHabitacion='".$_SESSION['reserva']['habitacion_id']."'");
            if(count($habitaciones_list) > 0) {
                $habitacion = $habitaciones_list[0];
                
                $entrada = new DateTime($_SESSION['reserva']['fecha_entrada']);
                $salida = new DateTime($_SESSION['reserva']['fecha_salida']);
                $dias = $entrada->diff($salida)->days;
                $total = $dias * $habitacion->precio;
            } else {
                $error = "Habitación no encontrada.";
                header('Location: reservar.php');
                exit();
            }
            ?>
            
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card public-form">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-white"><i class="fas fa-credit-card me-2"></i>Confirmar Reserva</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                    <div class="mt-2">
                                        <a href="reservar.php" class="btn btn-warning btn-sm">
                                            <i class="fas fa-arrow-left me-1"></i>Volver a intentar
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Detalles de la Reserva</h5>
                                    <div class="mb-4 p-3 bg-light rounded">
                                        <strong>Habitación:</strong> <?php echo $habitacion->tipo; ?><br>
                                        <strong>Entrada:</strong> <?php echo $entrada->format('d/m/Y'); ?><br>
                                        <strong>Salida:</strong> <?php echo $salida->format('d/m/Y'); ?><br>
                                        <strong>Noches:</strong> <?php echo $dias; ?><br>
                                        <strong>Huéspedes:</strong> <?php echo $_SESSION['reserva']['adultos']; ?> adultos, 
                                        <?php echo $_SESSION['reserva']['ninos']; ?> niños
                                    </div>
                                    
                                    <h5 class="text-primary mb-3">Información del Huésped</h5>
                                    <div class="p-3 bg-light rounded">
                                        <strong>Nombre:</strong> <?php echo $_SESSION['reserva']['nombre']; ?><br>
                                        <strong>Email:</strong> <?php echo $_SESSION['reserva']['email']; ?><br>
                                        <strong>Teléfono:</strong> <?php echo $_SESSION['reserva']['telefono']; ?><br>
                                        <strong>Documento:</strong> <?php echo $_SESSION['reserva']['documento']; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0">Resumen de Pago</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><?php echo $habitacion->tipo; ?> x <?php echo $dias; ?> noches</span>
                                                <span>$<?php echo number_format($habitacion->precio * $dias, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Precio por noche</span>
                                                <span>$<?php echo number_format($habitacion->precio, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Impuestos (16%)</span>
                                                <span>$<?php echo number_format($total * 0.16, 2); ?></span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold fs-5">
                                                <span>Total</span>
                                                <span class="text-primary">$<?php echo number_format($total * 1.16, 2); ?> MXN</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <form action="" method="post" class="mt-4">
                                        <input type="hidden" name="paso" value="2">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success btn-lg py-3">
                                                <i class="fas fa-lock me-2"></i>Confirmar y Finalizar Reserva
                                            </button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>
                                                Al confirmar, aceptas nuestros <a href="#" class="text-decoration-none">términos y condiciones</a>
                                            </small>
                                        </div>
                                    </form>
                                    
                                    <div class="text-center mt-3">
                                        <a href="reservar.php" class="btn btn-outline-secondary">
                                            <i class="fas fa-edit me-1"></i>Modificar Datos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Paso 1: Formulario de reserva -->
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card public-form">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-white"><i class="fas fa-calendar-plus me-2"></i>Nueva Reserva</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($habitacion_info): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Reservando:</strong> Habitación <?php echo $habitacion_info->tipo; ?> - 
                                    $<?php echo number_format($habitacion_info->precio, 2); ?> MXN por noche
                                </div>
                            <?php elseif(!isset($_GET['habitacion_id'])): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Selecciona una habitación:</strong> 
                                    <a href="habitaciones.php" class="alert-link">Ver habitaciones disponibles</a>
                                </div>
                            <?php endif; ?>
                            
                            <form action="reservar.php" method="post" id="formReserva">
                                <input type="hidden" name="paso" value="1">
                                <input type="hidden" name="habitacion_id" value="<?php echo $habitacion_info ? $habitacion_info->idHabitacion : ''; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Fechas de Estancia</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="fecha_entrada" class="form-label">Fecha de Entrada *</label>
                                                <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" required
                                                       min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="fecha_salida" class="form-label">Fecha de Salida *</label>
                                                <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="adultos" class="form-label">Adultos *</label>
                                                <select name="adultos" id="adultos" class="form-select" required>
                                                    <option value="1">1 Adulto</option>
                                                    <option value="2" selected>2 Adultos</option>
                                                    <option value="3">3 Adultos</option>
                                                    <option value="4">4 Adultos</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="ninos" class="form-label">Niños</label>
                                                <select name="ninos" id="ninos" class="form-select">
                                                    <option value="0" selected>0 Niños</option>
                                                    <option value="1">1 Niño</option>
                                                    <option value="2">2 Niños</option>
                                                    <option value="3">3 Niños</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Información Personal</h5>
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre Completo *</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                                   placeholder="Ej: Juan Pérez García" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" name="email" id="email" class="form-control" 
                                                       placeholder="ejemplo@correo.com" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="telefono" class="form-label">Teléfono *</label>
                                                <input type="tel" name="telefono" id="telefono" class="form-control" 
                                                       placeholder="+52 123 456 7890" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="documento" class="form-label">Documento de Identidad *</label>
                                            <input type="text" name="documento" id="documento" class="form-control" 
                                                   placeholder="INE, Pasaporte, etc." required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="habitaciones.php" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-1"></i>Volver a Habitaciones
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-1"></i>Continuar a Confirmación
                                    </button>
                                </div>
                                
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-asterisk me-1"></i>Los campos marcados con * son obligatorios
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function() {
            // Validación de fechas
            const today = new Date().toISOString().split('T')[0];
            $('#fecha_entrada').attr('min', today);
            
            $('#fecha_entrada').change(function() {
                if(this.value) {
                    const nextDay = new Date(this.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    $('#fecha_salida').attr('min', nextDay.toISOString().split('T')[0]);
                }
            });
            
            // Validación del formulario
            $('#formReserva').submit(function(e) {
                const entrada = new Date($('#fecha_entrada').val());
                const salida = new Date($('#fecha_salida').val());
                
                if (!entrada || !salida) {
                    alert('Por favor, selecciona ambas fechas');
                    e.preventDefault();
                    return false;
                }
                
                if (salida <= entrada) {
                    alert('La fecha de salida debe ser posterior a la fecha de entrada');
                    e.preventDefault();
                    return false;
                }
                
                const dias = (salida - entrada) / (1000 * 60 * 60 * 24);
                if (dias < 1) {
                    alert('La estancia mínima es de 1 noche');
                    e.preventDefault();
                    return false;
                }
                
                if (dias > 30) {
                    alert('La estancia máxima es de 30 noches');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>
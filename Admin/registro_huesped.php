<?php include('seguridad.php'); verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Huésped - Hotel Paradise</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold text-primary mb-1">
                            <i class="fas fa-user-plus me-2"></i>Registrar Nuevo Huésped
                        </h2>
                        <p class="text-muted mb-0">Complete la información del nuevo huésped</p>
                    </div>
                    <a href="consulta_huespedes.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle me-2"></i>Información Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="registro_huesped.php" method="post" id="formHuesped" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="idHuesped" class="form-label fw-semibold">
                                        <i class="fas fa-id-card me-1 text-muted"></i>ID Huésped
                                    </label>
                                    <input type="text" name="idHuesped" id="idHuesped" class="form-control form-control-lg" 
                                           placeholder="Ej: H12345" required pattern="[A-Z]{1,2}\d{4,6}">
                                    <div class="form-text">Formato: 1-2 letras + 4-6 números (ej: AB1234)</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="documento" class="form-label fw-semibold">
                                        <i class="fas fa-passport me-1 text-muted"></i>Documento de Identidad
                                    </label>
                                    <input type="text" name="documento" id="documento" class="form-control form-control-lg" 
                                           placeholder="Número de documento" required minlength="5">
                                    <div class="form-text">Pasaporte, DNI o identificación oficial</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-muted"></i>Nombre Completo
                                </label>
                                <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" 
                                       placeholder="Nombre y apellidos del huésped" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1 text-muted"></i>Teléfono
                                    </label>
                                    <input type="tel" name="telefono" id="telefono" class="form-control" 
                                           placeholder="+52 998 123 4567" pattern="[\+]?[0-9\s\-\(\)]{10,}">
                                    <div class="form-text">Formato internacional preferido</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-1 text-muted"></i>Email
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           placeholder="huesped@ejemplo.com">
                                    <div class="form-text">Para envío de confirmaciones</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmacion" required>
                                    <label class="form-check-label" for="confirmacion">
                                        Confirmo que la información es correcta
                                    </label>
                                </div>
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-undo me-1"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-1"></i>Registrar Huésped
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php
                        if($_SERVER["REQUEST_METHOD"] == "POST" && 
                           isset($_POST['idHuesped']) && 
                           isset($_POST['nombre']) && 
                           isset($_POST['documento'])){
                                
                            require_once('../includes/Huesped.php');

                            $h = new Huesped();
                            $h->idHuesped = $_POST['idHuesped'];
                            $h->nombre = $_POST['nombre'];
                            $h->telefono = $_POST['telefono'] ?? '';
                            $h->email = $_POST['email'] ?? '';
                            $h->documento = $_POST['documento'];

                            $res = $h->insertar();

                            if($res){
                                echo'<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>¡Éxito!</strong> El huésped se ha registrado correctamente.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>';
                                
                                // Limpiar formulario después de éxito
                                echo '<script>setTimeout(function(){ document.getElementById("formHuesped").reset(); }, 3000);</script>';
                            }else{
                                echo'<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Error:</strong> No se pudo registrar el huésped. Verifique los datos.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validación de formulario
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
        
        // Validación personalizada del ID Huésped
        document.getElementById('formHuesped').addEventListener('submit', function(e){
            let id = document.getElementById('idHuesped').value;
            let documento = document.getElementById('documento').value;
            
            // Validar formato del ID
            if(!/^[A-Z]{1,2}\d{4,6}$/.test(id)){
                alert('El ID de huésped debe comenzar con 1-2 letras mayúsculas seguidas de 4-6 números (ej. AB1234)');
                e.preventDefault();
                return false;
            }
            
            // Validar longitud del documento
            if(documento.length < 5){
                alert('El documento debe tener al menos 5 caracteres');
                e.preventDefault();
                return false;
            }
            
            return true;
        });
        
        // Auto-generar ID si está vacío
        document.getElementById('nombre').addEventListener('blur', function() {
            const idField = document.getElementById('idHuesped');
            if (!idField.value) {
                const nombres = this.value.split(' ');
                let iniciales = '';
                if (nombres.length >= 2) {
                    iniciales = (nombres[0].charAt(0) + nombres[1].charAt(0)).toUpperCase();
                } else if (nombres.length === 1) {
                    iniciales = nombres[0].charAt(0).toUpperCase() + 'X';
                } else {
                    iniciales = 'HX';
                }
                const numero = Math.floor(1000 + Math.random() * 9000);
                idField.value = iniciales + numero;
            }
        });
    </script>
</body>
</html>
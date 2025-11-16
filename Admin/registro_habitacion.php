<?php include('seguridad.php'); verificarAutenticacion(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Habitación - Hotel Paradise</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold text-primary mb-1">
                            <i class="fas fa-bed me-2"></i>Registrar Nueva Habitación
                        </h2>
                        <p class="text-muted mb-0">Complete el formulario para agregar una nueva habitación</p>
                    </div>
                    <a href="consulta_habitaciones.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Información de la Habitación
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="registro_habitacion.php" method="post" id="formHabitacion" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="idHabitacion" class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-1 text-muted"></i>ID Habitación
                                    </label>
                                    <input type="text" name="idHabitacion" id="idHabitacion" class="form-control form-control-lg" 
                                           placeholder="Ej: HAB001" required>
                                    <div class="form-text">Ingrese un identificador único para la habitación</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label fw-semibold">
                                        <i class="fas fa-tag me-1 text-muted"></i>Tipo de Habitación
                                    </label>
                                    <select name="tipo" id="tipo" class="form-select form-select-lg" required>
                                        <option value="">Seleccione un tipo</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Doble">Doble</option>
                                        <option value="Suite">Suite</option>
                                        <option value="Familiar">Familiar</option>
                                        <option value="Presidencial">Presidencial</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="capacidad" class="form-label fw-semibold">
                                        <i class="fas fa-users me-1 text-muted"></i>Capacidad
                                    </label>
                                    <input type="number" name="capacidad" id="capacidad" class="form-control form-control-lg" 
                                           min="1" max="6" value="2" required>
                                    <div class="form-text">Número máximo de huéspedes</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="precio" class="form-label fw-semibold">
                                        <i class="fas fa-dollar-sign me-1 text-muted"></i>Precio por Noche
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">$</span>
                                        <input type="number" name="precio" id="precio" class="form-control form-control-lg" 
                                               step="0.01" min="0" placeholder="0.00" required>
                                        <span class="input-group-text bg-light">MXN</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label fw-semibold">
                                        <i class="fas fa-circle me-1 text-muted"></i>Estado
                                    </label>
                                    <select name="estado" id="estado" class="form-select form-select-lg" required>
                                        <option value="Disponible" class="text-success">Disponible</option>
                                        <option value="Ocupada" class="text-warning">Ocupada</option>
                                        <option value="Mantenimiento" class="text-danger">Mantenimiento</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1 text-muted"></i>Descripción
                                </label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" 
                                          placeholder="Describa las características especiales de la habitación..."></textarea>
                                <div class="form-text">Ej: Vista al mar, jacuzzi privado, balcón, etc.</div>
                            </div>

                            <div class="mb-4">
                                <label for="imagen" class="form-label fw-semibold">
                                    <i class="fas fa-image me-1 text-muted"></i>Imagen de la Habitación
                                </label>
                                <input type="file" name="imagen" id="imagen" class="form-control form-control-lg" 
                                       accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 5MB</div>
                                
                                <!-- Vista previa de imagen -->
                                <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                    <img id="preview" class="img-thumbnail" style="max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                                        <i class="fas fa-times me-1"></i>Remover Imagen
                                    </button>
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
                                        <i class="fas fa-save me-1"></i>Guardar Habitación
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php
                        if($_SERVER["REQUEST_METHOD"] == "POST" && 
                           isset($_POST['idHabitacion']) && 
                           isset($_POST['tipo']) && 
                           isset($_POST['precio']) &&
                           isset($_POST['capacidad']) &&
                           isset($_POST['estado'])){
                            
                            require_once('../includes/Habitacion.php');

                            $nombreImagen = "default.jpg";
                            
                            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
                                $directorio = "../imagenes/habitaciones/";
                                if (!file_exists($directorio)) {
                                    mkdir($directorio, 0777, true);
                                }
                                
                                $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
                                $nombreImagen = uniqid() . "." . $extension;
                                $rutaImagen = $directorio . $nombreImagen;
                                
                                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
                                    // Éxito al subir la imagen
                                } else {
                                    $nombreImagen = "default.jpg";
                                }
                            }
                            
                            $h = new Habitacion();
                            $h->idHabitacion = $_POST['idHabitacion'];
                            $h->tipo = $_POST['tipo'];
                            $h->capacidad = $_POST['capacidad'];
                            $h->precio = $_POST['precio'];
                            $h->descripcion = $_POST['descripcion'] ?? '';
                            $h->estado = $_POST['estado'];
                            $h->imagen = $nombreImagen;

                            $res = $h->insertar();

                            if($res){
                                echo'<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>¡Éxito!</strong> La habitación se ha registrado correctamente.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>';
                            }else{
                                echo'<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Error:</strong> No se pudo registrar la habitación. Verifique los datos.
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
        // Vista previa de imagen
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function removeImage() {
            document.getElementById('imagen').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        }
        
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
        
        // Validación de precio
        document.getElementById('formHabitacion').addEventListener('submit', function(e) {
            const precio = document.getElementById('precio').value;
            if (precio <= 0) {
                alert('El precio debe ser mayor que cero');
                e.preventDefault();
                return false;
            }
            return true;
        });
    </script>
</body>
</html>
<?php
require_once('../includes/Huesped.php');
$h = new Huesped();

// Obtener datos del huésped a editar
if(isset($_GET['id'])){
    $huesped = $h->consultar("idHuesped = '".$_GET['id']."'");
    if(count($huesped) > 0){
        $huesped = $huesped[0];
    } else {
        header('Location: consulta_huespedes.php');
        exit();
    }
} else {
    header('Location: consulta_huespedes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Huésped</title>
    <?php include('../includes/cabecera.php'); ?>
</head>
<body>
    <?php include('menu_admin.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card admin-form">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Huésped</h4>
                    </div>
                    <div class="card-body">
                        <form action="actualizar_huesped.php" method="post" onsubmit="return validarFormulario()">
                            <div class="mb-3">
                                <label for="idHuesped" class="form-label">ID Huésped:</label>
                                <input type="text" name="idHuesped" id="idHuesped" class="form-control" 
                                       value="<?php echo $huesped->idHuesped; ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" 
                                       value="<?php echo $huesped->nombre; ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono:</label>
                                        <input type="tel" name="telefono" id="telefono" class="form-control" 
                                               value="<?php echo $huesped->telefono; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo electrónico:</label>
                                        <input type="email" name="correo" id="correo" class="form-control" 
                                               value="<?php echo $huesped->email; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="documento" class="form-label">Documento de identidad:</label>
                                <input type="text" name="documento" id="documento" class="form-control" 
                                       value="<?php echo $huesped->documento; ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save me-1"></i>Actualizar
                                </button>
                                <a href="consulta_huespedes.php" class="btn btn-secondary">
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
            // Validar teléfono (al menos 8 dígitos)
            const telefono = document.getElementById('telefono').value;
            if (telefono && !/^\d{8,}$/.test(telefono)) {
                alert('El teléfono debe contener al menos 8 dígitos');
                return false;
            }

            // Validar documento (al menos 6 caracteres)
            const documento = document.getElementById('documento').value;
            if (documento.length < 6) {
                alert('El documento debe tener al menos 6 caracteres');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
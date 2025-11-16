<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if(isset($_SESSION['admin_logueado']) && $_SESSION['admin_logueado'] === true){
    header('Location: dashboard.php');
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Usuarios válidos (en producción, guardar en base de datos)
    $usuarios_validos = [
        'admin' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password: password
    ];
    
    if(isset($usuarios_validos[$usuario]) && password_verify($password, $usuarios_validos[$usuario])){
        $_SESSION['admin_logueado'] = true;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['timeout'] = time() + 3600; // 1 hora
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            border: none;
        }
        .hotel-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 3.5rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-home {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white !important;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="hotel-icon mb-3">
                    <i class="fas fa-hotel"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Hotel Paradise</h2>
                <p class="text-muted">Sistema de Administración</p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-primary"></i>
                        </span>
                        <input type="text" name="usuario" class="form-control border-start-0" 
                               placeholder="Ingresa tu usuario" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0" 
                               placeholder="Ingresa tu contraseña" required>
                    </div>
                </div>
                
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-login text-white w-100 py-2 fw-semibold">
                        <i class="fas fa-sign-in-alt me-2"></i>Ingresar al Sistema
                    </button>
                    
                    <!-- BOTÓN CORREGIDO: Ahora apunta a la carpeta public -->
                    <a href="../public/index.php" class="btn btn-home w-100 py-2 fw-semibold">
                        <i class="fas fa-home me-2"></i>Volver al Sitio Web
                    </a>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>
                    Acceso restringido al personal autorizado
                </small>
            </div>
        </div>
    </div>
</body>
</html>
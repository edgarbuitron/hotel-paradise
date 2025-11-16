<?php
class Conexion{
    private $servidor;
    private $usuario;
    private $pass;
    private $bd;
    private $puerto;
    public $enlace;

    public function __construct(){
        // Para Render - usar variable de entorno DATABASE_URL
        if(getenv('DATABASE_URL')){
            $dbUrl = parse_url(getenv('DATABASE_URL'));
            $this->servidor = $dbUrl['host'];
            $this->usuario = $dbUrl['user'];
            $this->pass = $dbUrl['pass'];
            $this->bd = ltrim($dbUrl['path'], '/');
            $this->puerto = $dbUrl['port'] ?? 5432;
        } else {
            // Configuración local de respaldo
            $this->servidor = "localhost";
            $this->usuario = "root";
            $this->pass = "";
            $this->bd = "hotel";
            $this->puerto = 3306;
        }
    }

    public function conectar(){
        if(getenv('DATABASE_URL')){
            // Conexión PostgreSQL para Render
            $dsn = "pgsql:host={$this->servidor};port={$this->puerto};dbname={$this->bd}";
            try {
                $this->enlace = new PDO($dsn, $this->usuario, $this->pass);
                $this->enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return true;
            } catch(PDOException $e) {
                error_log("Error PostgreSQL: " . $e->getMessage());
                return false;
            }
        } else {
            // Conexión MySQL local
            $this->enlace = mysqli_connect($this->servidor, $this->usuario, $this->pass, $this->bd, $this->puerto);
            if(mysqli_connect_errno()){
                error_log('Error MySQL: ' . mysqli_connect_error());
                return false;
            }
            return true;
        }
    }
}
?>

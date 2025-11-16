<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Simular datos de reserva en sesión
$_SESSION['reserva'] = [
    'nombre' => 'Juan Perez',
    'email' => 'test@test.com',
    'telefono' => '1234567890',
    'documento' => 'TEST123',
    'habitacion_id' => '18', // Cambia por un ID que exista en tu BD
    'fecha_entrada' => '2024-01-15',
    'fecha_salida' => '2024-01-17',
    'adultos' => '2',
    'ninos' => '0'
];

echo "<h1>Test de Reserva</h1>";
echo "<p>Datos de sesión simulados.</p>";
echo "<form action='reservar.php' method='post'>";
echo "<input type='hidden' name='paso' value='2'>";
echo "<button type='submit'>Probar Reserva Paso 2</button>";
echo "</form>";
?>
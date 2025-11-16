CREATE DATABASE hotel;

USE hotel;

-- Tabla Habitaciones
CREATE TABLE habitaciones (
    idHabitacion VARCHAR(10) PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    estado ENUM('Disponible', 'Ocupada', 'Mantenimiento') DEFAULT 'Disponible'
);

-- Tabla Huespedes
CREATE TABLE huespedes (
    idHuesped VARCHAR(10) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100),
    documento VARCHAR(20) NOT NULL
);

-- Tabla Reservaciones
CREATE TABLE reservaciones (
    idReservacion INT AUTO_INCREMENT PRIMARY KEY,
    idHuesped VARCHAR(10) NOT NULL,
    idHabitacion VARCHAR(10) NOT NULL,
    fechaEntrada DATE NOT NULL,
    fechaSalida DATE NOT NULL,
    estado ENUM('Pendiente', 'Confirmada', 'Cancelada', 'Finalizada') DEFAULT 'Pendiente',
    FOREIGN KEY (idHuesped) REFERENCES huespedes(idHuesped),
    FOREIGN KEY (idHabitacion) REFERENCES habitaciones(idHabitacion),
    CHECK (fechaSalida > fechaEntrada)
);
























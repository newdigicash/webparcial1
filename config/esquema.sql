CREATE TABLE Vehiculos (
    vehiculo_id INT PRIMARY KEY AUTO_INCREMENT,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE Clientes (
    cliente_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    licencia VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL
);

CREATE TABLE Alquileres (
    alquiler_id INT PRIMARY KEY AUTO_INCREMENT,
    vehiculo_id INT NOT NULL,
    cliente_id INT NOT NULL,
    fecha_entrega TIMESTAMP NOT NULL,
    fecha_devolucion_estimada TIMESTAMP NOT NULL,
    fecha_devolucion TIMESTAMP NULL,
    tarifa_hora DECIMAL(10, 2) NOT NULL CHECK (tarifa_hora >= 0),
    abono DECIMAL(10, 2) NOT NULL DEFAULT 0.00 CHECK (abono >= 0),
    total_pagado DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    estado VARCHAR(1) NOT NULL DEFAULT 'A',

    CONSTRAINT fk_alquiler_vehiculo
        FOREIGN KEY (vehiculo_id) REFERENCES Vehiculos(vehiculo_id),
    CONSTRAINT fk_alquiler_cliente
        FOREIGN KEY (cliente_id) REFERENCES Clientes(cliente_id),
    CONSTRAINT chk_fechas_estimadas
        CHECK (fecha_devolucion_estimada >= fecha_entrega),
    CONSTRAINT chk_fecha_devolucion_real
        CHECK (fecha_devolucion IS NULL OR fecha_devolucion >= fecha_entrega)
);

CREATE DATABASE IF NOT EXISTS intelafix_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE intelafix_db;

CREATE TABLE usuarios (
    id BIGINT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR (250) NOT NULL,
    correo VARCHAR (250) NOT NULL,
    clave_acceso VARCHAR (250) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS stores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    photo_path VARCHAR(255),
    position_id INT NOT NULL,
    salary DECIMAL(10,2) NOT NULL CHECK (salary >= 0),
    store_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    type ENUM('positive', 'negative') NOT NULL,
    occurrence_date DATE NOT NULL,
    employee_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO positions (name) VALUES
('Gerente General'),
('Supervisor de Tienda'),
('Vendedor'),
('Técnico de Soporte'),
('Administrador de Inventario');

INSERT INTO stores (name) VALUES
('Tienda Central'),
('Sucursal Norte'),
('Sucursal Sur'),
('Sucursal Este'),
('Sucursal Oeste');

INSERT INTO employees (first_name, last_name, date_of_birth, photo_path, position_id, salary, store_id) VALUES
('Juan', 'Pérez', '1985-06-15', 'photos/juan_perez.jpg', 1, 5000.00, 1),
('María', 'González', '1990-09-22', 'photos/maria_gonzalez.jpg', 3, 3000.00, 2),
('Carlos', 'Ramírez', '1988-12-05', 'photos/carlos_ramirez.jpg', 4, 3500.00, 3),
('Ana', 'Martínez', '1992-03-18', 'photos/ana_martinez.jpg', 2, 4000.00, 4),
('Luis', 'Hernández', '1987-11-30', 'photos/luis_hernandez.jpg', 5, 2800.00, 5);

INSERT INTO achievements (description, type, occurrence_date, employee_id) VALUES
('Excelente atención al cliente durante el lanzamiento de nuevo producto.', 'positive', '2024-03-10', 2),
('Retraso en la entrega de inventario por problemas logísticos.', 'negative', '2024-04-05', 5),
('Implementación exitosa de un nuevo sistema de inventario.', 'positive', '2024-02-20', 5),
('Incumplimiento de metas de ventas en el último trimestre.', 'negative', '2024-01-15', 3),
('Reconocimiento por liderazgo en equipo.', 'positive', '2024-03-25', 1);

CREATE INDEX idx_employees_position_id ON employees(position_id);
CREATE INDEX idx_employees_store_id ON employees(store_id);
CREATE INDEX idx_achievements_employee_id ON achievements(employee_id);

-- Consultas para Generar Reportes/Informes
-- a. Lista general de empleados
SELECT 
    e.id,
    e.first_name,
    e.last_name,
    e.date_of_birth,
    e.photo_path,
    p.name AS position,
    e.salary,
    s.name AS store
FROM 
    employees e
JOIN 
    positions p ON e.position_id = p.id
JOIN 
    stores s ON e.store_id = s.id;

-- a. ii. Totalizar el salario de todos los empleados
SELECT 
    SUM(salary) AS total_salary
FROM 
    employees;

-- b. Lista de salarios de empleados por tienda
SELECT 
    s.name AS store,
    e.first_name,
    e.last_name,
    e.salary
FROM 
    employees e
JOIN 
    stores s ON e.store_id = s.id
ORDER BY 
    s.name ASC, e.salary DESC;

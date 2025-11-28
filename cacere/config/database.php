<?php
/**
 * Configuración de la base de datos
 */
// Configuración de conexión a MySQL
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Por defecto en XAMPP está vacía
define('DB_DATABASE', '50bendiciones');
define('DB_PORT', '3306');

/**
 * Función para obtener conexión a la base de datos
 */
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_DATABASE . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

/**
 * Función para crear la base de datos y tabla si no existen
 */
function initializeDatabase() {
    try {
        // Conectar sin especificar base de datos
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Crear base de datos si no existe
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_DATABASE);
        
        // Seleccionar la base de datos
        $pdo->exec("USE " . DB_DATABASE);
        
        $createTableSQL = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombreu VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telefono VARCHAR(20) NOT NULL,
                fecha_registro DATETIME 
            ) 
        ";
                $createTableSQL2 = "CREATE TABLE IF NOT EXISTS empleados (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                apellido VARCHAR(100) NOT NULL,
                telefonoe VARCHAR(20) NOT NULL,
                fecha_registro DATETIME 
            ) 
        ";
        $createTableSQL3 = "CREATE TABLE IF NOT EXISTS clientes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombrec VARCHAR(100) NOT NULL,
                cuil VARCHAR(15) NOT NULL,
                telefonoc VARCHAR(20) NOT NULL,
                fecha_registro DATETIME 
            ) 
        ";
        $createTableSQL4 = "CREATE TABLE IF NOT EXISTS trabajohecho (
            id INT AUTO_INCREMENT PRIMARY KEY,
            postal INT NOT NULL,
            direccion VARCHAR(20) NOT NULL,
            telefonor INT NOT NULL,
            fecha_registro DATETIME 
            )
        ";
        $createTableSQL5 = "CREATE TABLE IF NOT EXISTS trabajoinconcluso (
            id INT AUTO_INCREMENT PRIMARY KEY,
            postales INT NOT NULL,
            direcciones VARCHAR(100) NOT NULL,
            telefonoss INT NOT NULL,
            fecha_registro DATETIME 
            ) 
        ";
        $pdo->exec($createTableSQL5);
        $pdo->exec($createTableSQL4);
        $pdo->exec($createTableSQL);
        $pdo->exec($createTableSQL2);
        $pdo->exec($createTableSQL3);

        return true;
    } catch (PDOException $e) {
        return "Error al inicializar la base de datos: " . $e->getMessage();
    }
}
?>
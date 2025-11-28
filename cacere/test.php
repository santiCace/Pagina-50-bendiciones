<?php
/**
 * Archivo de prueba para verificar la conexión y funcionalidad
 * Ejecuta este archivo para probar que todo funcione correctamente
 */

echo "<h1>🔧 Test de la aplicación PHP - MySQL</h1>";
echo "<hr>";

// Test 1: Verificar PHP
echo "<h2>1. ✅ Test de PHP</h2>";
echo "<p><strong>Versión de PHP:</strong> " . phpversion() . "</p>";

if (version_compare(phpversion(), '7.0.0', '>=')) {
    echo "<p style='color: green;'>✅ PHP 7+ detectado correctamente</p>";
} else {
    echo "<p style='color: red;'>❌ Se requiere PHP 7.0 o superior</p>";
}

// Test 2: Verificar extensiones necesarias
echo "<h2>2. 📦 Test de extensiones PHP</h2>";

$extensiones = ['pdo', 'pdo_mysql', 'mysqli'];
foreach ($extensiones as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color: green;'>✅ $ext: Disponible</p>";
    } else {
        echo "<p style='color: red;'>❌ $ext: No disponible</p>";
    }
}

// Test 3: Verificar archivos del proyecto
echo "<h2>3. 📁 Test de archivos del proyecto</h2>";

$archivos = [
    'config/database.php',
    'index.php',
    'agregar U.php',
    'agregar E.php',
    'agregar C.php',
    'usuarios.php',
    'empleados.php',
    'clientes.php',
    'css/style.css'
];

foreach ($archivos as $archivo) {
    if (file_exists($archivo)) {
        echo "<p style='color: green;'>✅ $archivo: Existe</p>";
    } else {
        echo "<p style='color: red;'>❌ $archivo: No encontrado</p>";
    }
}

// Test 4: Verificar conexión a la base de datos
echo "<h2>4. 🗄️ Test de conexión a MySQL</h2>";

try {
    require_once 'config/database.php';
    
    // Intentar conexión
    $pdo = getConnection();
    echo "<p style='color: green;'>✅ Conexión a MySQL: Exitosa</p>";
    
    // Verificar que la BD existe
    $stmt = $pdo->query("SELECT DATABASE() as db_name");
    $result = $stmt->fetch();
    echo "<p><strong>Base de datos actual:</strong> " . $result['db_name'] . "</p>";
    
    // Verificar que la tabla existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Tabla 'usuarios': Existe</p>";
        
        // Contar registros
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
        $count = $stmt->fetch();
        echo "<p><strong>Usuarios registrados:</strong> " . $count['total'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Tabla 'usuarios': No existe (se creará automáticamente)</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de conexión: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Verificaciones:</strong></p>";
    echo "<ul>";
    echo "<li>¿Está XAMPP ejecutándose?</li>";
    echo "<li>¿Está el servicio MySQL activo?</li>";
    echo "<li>¿Son correctas las credenciales en config/database.php?</li>";
    echo "</ul>";
}

// Test 5: Test de inserción (opcional)
echo "<h2>5. 📝 Test de operaciones BD (opcional)</h2>";

if (isset($_GET['test_insert']) && $_GET['test_insert'] === '1') {
    try {
        $pdo = getConnection();
        
        // Insertar usuario de prueba
        $sql = "INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'Usuario Prueba ' . date('H:i:s'),
            'test_' . time() . '@ejemplo.com',
            '+54 11 1234-5678'
        ]);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Inserción de prueba: Exitosa</p>";
            echo "<p>Usuario de prueba creado correctamente</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error en inserción: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p><a href='?test_insert=1' style='color: blue;'>🔗 Ejecutar test de inserción</a></p>";
}

echo "<hr>";
echo "<h2>🎯 Resultado final</h2>";

if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
    echo "<p style='color: green; font-size: 1.2em;'><strong>✅ Sistema listo para usar</strong></p>";
    echo "<p><a href='index.php' style='color: blue; font-size: 1.1em;'>🚀 Ir a la aplicación principal</a></p>";
} else {
    echo "<p style='color: red; font-size: 1.2em;'><strong>❌ Sistema no está listo</strong></p>";
    echo "<p>Soluciona los problemas marcados arriba antes de continuar.</p>";
}

echo "<hr>";
echo "<p><small>Test ejecutado el: " . date('d/m/Y H:i:s') . "</small></p>";
?>
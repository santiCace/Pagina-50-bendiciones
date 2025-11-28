<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleado - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Agregar nuevo Empleado</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="empleados.php">Ver Empleados</a></li>
                <li><a href="trabajoinconcluso.php">Ver trabajos inconclusos</a></li>
                <li><a href="agregarEmpleados.php" class="active">Agregar Empleado</a></li>
                <li><a href="agregarI.php">Agregar trabajos inconclusos</a></li>
            </ul>
        </nav>

        <main>
            <?php
            require_once 'config/database.php';
            
            $message = '';
            $messageType = '';
            
            // Procesar formulario si se envió
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = trim($_POST['nombre'] ?? '');
                $apellido = trim($_POST['apellido'] ?? '');
                $telefonoe = trim($_POST['telefonoe'] ?? '');
                
                // Validación básica
                if (empty($nombre) || empty($apellido)) {
                    $message = 'El nombre y el apellido son obligatorios.';
                    $messageType = 'error';
                } else {
                    try {
                        $pdo = getConnection();
                        
                        // Preparar la consulta INSERT
                        $sql = "INSERT INTO empleados (nombre, apellido) VALUES (:nombre, :apellido, :telefonoe)";
                        $stmt = $pdo->prepare($sql);
                        
                        // Ejecutar la consulta
                        $result = $stmt->execute([
                            ':nombre' => $nombre,
                            ':apellido' => $apellido,
                            ':telefonoe' => $telefonoe,
                        ]);
                        
                        if ($result) {
                            $message = '✅ Empleado agregado exitosamente.';
                            $messageType = 'success';
                            // Limpiar formulario después del éxito
                            $_POST = [];
                        } else {
                            $message = '❌ Error al agregar el usuario.';
                            $messageType = 'error';
                        }
                        
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) { // Código de error para duplicado
                            $message = '⚠️ Ya existe un usuario con ese email.';
                            $messageType = 'warning';
                        } else {
                            $message = '❌ Error de base de datos: ' . $e->getMessage();
                            $messageType = 'error';
                        }
                    }
                }
            }
            
            // Mostrar mensaje si existe
            if (!empty($message)) {
                echo "<div class='alert $messageType'>$message</div>";
            }
            ?>

            <div class="form-section">
                <h2>➕ Agregar Nuevo Empleado</h2>
                
                <form method="POST" action="agregarEmpleados.php" class="user-form">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
                            placeholder="Ej: Joselito"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="apellido">Apellido *</label>
                        <input 
                            type="text" 
                            id="apellido" 
                            name="apellido" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>"
                            placeholder="Ej: Prado"
                        >
                    </div>
                    <div class="form-group">
                        <label for="telefonoe">Apellido *</label>
                        <input 
                            type="text" 
                            id="telefonoe" 
                            name="telefonoe" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['telefonoe'] ?? ''); ?>"
                            placeholder="Ej: +54 11 1234 5678"
                        >
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn primary">
                            <span>💾</span> Guardar Empleado
                        </button>
                        <a href="empleados.php" class="btn secondary">
                            <span>👥</span> Ver Empleados
                        </a>
                    </div>
                </form>
            </div>
            
        </main>

        <footer>
            <p>&copy; Desde 2025 hasta el dia de hoy.</p>
        </footer>
    </div>
</body>
</html>
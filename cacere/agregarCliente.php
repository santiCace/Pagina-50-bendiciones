<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Agregar nuevo Cliente</p>
        </header>

        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="clientes.php">Ver Clientes</a></li>
                <li><a href="agregarCliente.php" class="active">Agregar Cliente</a></li>
            </ul>
        </nav>

        <main>
            <?php
            require_once 'config/database.php';
            
            $message = '';
            $messageType = '';
            
            // Procesar formulario si se envió
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombrec = trim($_POST['nombrec'] ?? '');
                $cuil = trim($_POST['cuil'] ?? '');
                $telefonoc = trim($_POST['telefonoc'] ?? '');
                
                // Validación básica
                if (empty($nombrec) || empty($cuil) || empty($telefonoc)) {
                    $message = 'Nombre, Cuil y telefono son obligatorios.';
                    $messageType = 'error';
                } else {
                    try {
                        $pdo = getConnection();
                        
                        // Preparar la consulta INSERT
                        $sql = "INSERT INTO clientes (nombrec, cuil, telefonoc) VALUES (:nombrec, :cuil, :telefonoc)";
                        $stmt = $pdo->prepare($sql);
                        
                        // Ejecutar la consulta
                        $result = $stmt->execute([
                            ':nombrec' => $nombrec,
                            ':cuil' => $cuil,
                            ':telefonoc' => $telefonoc,
                        ]);
                        
                        if ($result) {
                            $message = '✅ Cliente agregado exitosamente.';
                            $messageType = 'success';
                            // Limpiar formulario después del éxito
                            $_POST = [];
                        } else {
                            $message = '❌ Error al agregar el cliente.';
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
                <h2>➕ Agregar Nuevo Cliente</h2>
                
                <form method="POST" action="agregarCliente.php" class="user-form">
                <div class="form-group">
                        <label for="nombrec">Nombre completo *</label>
                        <input 
                            type="text" 
                            id="nombrec" 
                            name="nombrec" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['nombrec'] ?? ''); ?>"
                            placeholder="Ej: Peralta Ramoz"
                        >
                    </div>
    
                <div class="form-group">
                        <label for="cuil">Cuil *</label>
                        <input 
                            type="text" 
                            id="cuil" 
                            name="cuil" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['cuil'] ?? ''); ?>"
                            placeholder="Ej: 20-12.345.678-1"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="telefonoc">Telefono *</label>
                        <input 
                            type="text" 
                            id="telefonoc" 
                            name="telefonoc" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['telefonoc'] ?? ''); ?>"
                            placeholder="Ej: +54 11 2015-2026"
                        >
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn primary">
                            <span>💾</span> Guardar Cliente
                        </button>
                        <a href="clientes.php" class="btn secondary">
                            <span>👥</span> Ver Clientes
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
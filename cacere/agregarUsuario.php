<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Agregar nuevo usuario</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="usuarios.php">Ver Usuarios</a></li>
                <li><a href="trabajohecho.php">Ver trabajos hechos</a></li>
                <li><a href="agregarUsuario.php" class="active">Agregar Usuario</a></li>
                <li><a href="agregarH.php">Agregar trabajos hechos</a></li>
            </ul>
        </nav>

        <main>
            <?php
            require_once 'config/database.php';
            
            $message = '';
            $messageType = '';
            
            // Procesar formulario si se envió
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombreu = trim($_POST['nombreu'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $telefono = trim($_POST['telefono'] ?? '');
                
                // Validación básica
                if (empty($nombreu) || empty($email)) {
                    $message = 'El nombre y el email son obligatorios.';
                    $messageType = 'error';
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = 'El formato del email no es válido.';
                    $messageType = 'error';
                } else {
                    try {
                        $pdo = getConnection();
                        
                     // Preparar la consulta INSERT
                        $sql = "INSERT INTO usuarios (nombreu, email, telefono) VALUES (:nombreu, :email, :telefono)";
                        $stmt = $pdo->prepare($sql);
                        
                        // Ejecutar la consulta
                        $result = $stmt->execute([
                            ':nombreu' => $nombreu,
                            ':email' => $email,
                            ':telefono' => $telefono
                        ]);
                        
                        if ($result) {
                            $message = '✅ Usuario agregado exitosamente.';
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
                <h2>➕ Agregar Nuevo Usuario</h2>
                
                <form method="POST" action="agregarUsuario.php" class="user-form">
                    <div class="form-group">
                        <label for="nombreu">Nombre completo *</label>
                        <input 
                            type="text" 
                            id="nombreu" 
                            name="nombreu" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['nombreu'] ?? ''); ?>"
                            placeholder="Ej: Juan Pérez"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            placeholder="Ej: juan@email.com"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono" 
                            value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>"
                            placeholder="Ej: +54 11 1234-5678"
                        >
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn primary">
                            <span>💾</span> Guardar Usuario
                        </button>
                        <a href="usuarios.php" class="btn secondary">
                            <span>👥</span> Ver Usuarios
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
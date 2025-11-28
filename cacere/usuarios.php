<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Lista de usuarios registrados</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="usuarios.php" class=active>Ver Usuarios</a></li>
                <li><a href="trabajohecho.php">Ver trabajos hechos</a></li>
                <li><a href="agregarUsuario.php">Agregar Usuario</a></li>
                <li><a href="agregarH.php">Agregar trabajo hechos</a></li>

            </ul>
        </nav>

        <main>
            <?php
            require_once 'config/database.php';
            
            $message = '';
            $messageType = '';
            
            // Procesar eliminación si se solicita
            if (isset($_GET['eliminar'])) {
                $id = intval($_GET['eliminar']);
                
                try {
                    $pdo = getConnection();
                    $sql = "DELETE FROM usuarios WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $result = $stmt->execute([':id' => $id]);
                    
                    if ($result && $stmt->rowCount() > 0) {
                        $message = '✅ Usuario eliminado exitosamente.';
                        $messageType = 'success';
                    } else {
                        $message = '⚠️ No se encontró el usuario a eliminar.';
                        $messageType = 'warning';
                    }
                } catch (PDOException $e) {
                    $message = '❌ Error al eliminar usuario: ' . $e->getMessage();
                    $messageType = 'error';
                }
            }
            
            // Obtener término de búsqueda
            $buscar = trim($_GET['buscar'] ?? '');
            
            // Mostrar mensaje si existe
            if (!empty($message)) {
                echo "<div class='alert $messageType'>$message</div>";
            }
            ?>

            <div class="users-section">
                <div class="section-header">
                    <h2>👥 Lista de Usuarios</h2>
                    <a href="agregarU.php" class="btn primary">
                        <span>➕</span> Nuevo Usuario
                    </a>
                </div>

                <!-- Formulario de búsqueda -->
                <div class="search-section">
                    <form method="GET" action="usuarios.php" class="search-form">
                        <input 
                            type="text" 
                            name="buscar" 
                            placeholder="Buscar por nombre o email..." 
                            value="<?php echo htmlspecialchars($buscar); ?>"
                            class="search-input"
                        >
                        <button type="submit" class="btn secondary">
                            <span>🔍</span> Buscar
                        </button>
                        <?php if (!empty($buscar)): ?>
                            <a href="usuarios.php" class="btn outline">
                                <span>✖️</span> Limpiar
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php
                try {
                    $pdo = getConnection();
                    
                    // Construir consulta con o sin búsqueda
                    if (!empty($buscar)) {
                        $sql = "SELECT * FROM usuarios WHERE nombreu LIKE :buscar OR email LIKE :buscar ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':buscar' => "%$buscar%"]);
                        echo "<p class='search-info'>🔍 Resultados para: <strong>" . htmlspecialchars($buscar) . "</strong></p>";
                    } else {
                        $sql = "SELECT * FROM usuarios ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }
                    
                    $usuarios = $stmt->fetchAll();
                    $totalUsuarios = count($usuarios);
                    
                    if ($totalUsuarios > 0) {
                        echo "<p class='users-count'>📊 Total de usuarios: <strong>$totalUsuarios</strong></p>";
                        
                        echo "<div class='table-responsive'>";
                        echo "<table class='users-table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Nombre</th>";
                        echo "<th>Email</th>";
                        echo "<th>Teléfono</th>";
                        echo "<th>Fecha Registro</th>";
                        echo "<th>Acciones</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        foreach ($usuarios as $usuario) {
                            $fechaFormateada = date('d/m/Y H:i', strtotime($usuario['fecha_registro']));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['nombreu']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                            echo "<td>" . (!empty($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '<em>No especificado</em>') . "</td>";
                            echo "<td>" . $fechaFormateada . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='usuarios.php?eliminar=" . $usuario['id'] . "' ";
                            echo "class='btn danger btn-small' ";
                            echo "onclick='return confirm(\"¿Estás seguro de eliminar a " . htmlspecialchars($usuario['nombreu']) . "?\");'>";
                            echo "<span>🗑️</span> Eliminar";
                            echo "</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        if (!empty($buscar)) {
                            echo "<div class='empty-state'>";
                            echo "<div class='empty-icon'>🔍</div>";
                            echo "<h3>No se encontraron resultados</h3>";
                            echo "<p>No hay usuarios que coincidan con '<strong>" . htmlspecialchars($buscar) . "</strong>'</p>";
                            echo "<a href='usuarios.php' class='btn secondary'>Ver todos los usuarios</a>";
                            echo "</div>";
                        } else {
                            echo "<div class='empty-state'>";
                            echo "<div class='empty-icon'>👥</div>";
                            echo "<h3>No hay usuarios registrados</h3>";
                            echo "<p>Comienza agregando tu primer usuario</p>";
                            echo "<a href='agregarU.php' class='btn primary'>Agregar primer usuario</a>";
                            echo "</div>";
                        }
                    }
                    
                } catch (PDOException $e) {
                    echo "<div class='alert error'>";
                    echo "<h3>❌ Error de base de datos:</h3>";
                    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </main>

        <footer>
            <p>&copy; Desde 2025 hasta el dia de hoy.</p>
        </footer>
    </div>

    <script>
        // Confirmar eliminación con JavaScript
        function confirmarEliminacion(nombreu, id) {
            if (confirm('¿Estás seguro de eliminar a ' + nombreu + '?')) {
                window.location.href = 'usuarios.php?eliminar=' + id;
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios de 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Lista de Trabajos inconclusos</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="usuarios.php">Ver Usuarios</a></li>
                <li><a href="trabajoinconcluso.php" class=active>Ver trabajos inconclusos</a></li>
                <li><a href="agregarUsuario.php">Agregar Usuario</a></li>
                <li><a href="agregarI.php">Agregar trabajos inconclusos</a></li>

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
                    $sql = "DELETE FROM trabajoinconcluso WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $result = $stmt->execute([':id' => $id]);
                    
                    if ($result && $stmt->rowCount() > 0) {
                        $message = '✅ trabajo inconcluso eliminado exitosamente.';
                        $messageType = 'success';
                    } else {
                        $message = '⚠️ No se encontró el trabajo inconcluso a eliminar.';
                        $messageType = 'warning';
                    }
                } catch (PDOException $e) {
                    $message = '❌ Error al eliminar el trabajo inconcluso: ' . $e->getMessage();
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
                    <h2>👥 Lista de trabajos incompletos</h2>
                    <a href="agregarI.php" class="btn primary">
                        <span>➕</span> Nuevo trabajo
                    </a>
                </div>

                <?php
                try {
                    $pdo = getConnection();

                    // Construir consulta con o sin búsqueda
                    if (!empty($buscar)) {
                        $sql = "SELECT * FROM trabajoinconcluso WHERE id LIKE :buscar ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':buscar' => "%$buscar%"]);
                        echo "<p class='search-info'>🔍 Resultados para: <strong>" . htmlspecialchars($buscar) . "</strong></p>";
                    } else {
                        $sql = "SELECT * FROM trabajoinconcluso ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }
                    
                    $trabajoinconcluso = $stmt->fetchAll();
                    $totaltrabajoinconcluso = count($trabajoinconcluso);
                    
                    if ($totaltrabajoinconcluso > 0) {
                        echo "<p class='users-count'>📊 Total de trabajos inconclusos: <strong>$totaltrabajoinconcluso</strong></p>";
                        
                        echo "<div class='table-responsive'>";
                        echo "<table class='users-table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>agregar postales</th>";
                        echo "<th>agregar direcciones</th>";
                        echo "<th>agregar telefonoss</th>";
                        echo "<th>agregar empleadosss</th>";
                        echo "<th>Fecha Registro</th>";
                        echo "<th>Acciones</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        foreach ($trabajoinconcluso as $inconcluso ) {
                            $fechaFormateada = date('d/m/Y H:i', strtotime($inconcluso['fecha_registro']));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($hecho['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($hecho['postales']) . "</td>";
                            echo "<td>" . htmlspecialchars($hecho['direcciones']) . "</td>";
                            echo "<td>" . htmlspecialchars($hecho['telefonoss']) . "</td>";
                            echo "<td>" . (!empty($hecho['empleadosss']) ? htmlspecialchars($inconcluso['empleadosss']) : '<em>No especificado</em>') . "</td>";
                            echo "<td>" . $fechaFormateada . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='editarP.php?id=" . $inconcluso['id'] . "' ";
                            echo "class='btn secondary btn-small' ";
                            echo "<span>✏️</span> Editar";
                            echo "<a href='trabajoinconcluso.php?eliminar=" . $inconcluso['id'] . "' ";
                            echo "class='btn danger btn-small' ";
                            echo "onclick='return confirm(\"¿Estás seguro de eliminar a " . htmlspecialchars($inconcluso['id']) . "?\");'>";
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
                            echo "<p>No hay trabajos inconclusos que coincidan con '<strong>" . htmlspecialchars($buscar) . "</strong>'</p>";
                            echo "<a href='trabajoinconcluso.php' class='btn secondary'>Ver todos los trabajos inconclusos</a>";
                            echo "</div>";
                        } else {
                            echo "<div class='empty-state'>";
                            echo "<div class='empty-icon'>👥</div>";
                            echo "<h3>No hay trabajos inconclusos registrados</h3>";
                            echo "<p>Comienza agregando tu primer trabajo inconclusos</p>";
                            echo "<a href='agregarUsuario.php' class='btn primary'>Agregar primer trabajo inconcluso</a>";
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
                window.location.href = 'trabajoinconcluso.php?eliminar=' + id;
            }
        }
    </script>
</body>
</html>
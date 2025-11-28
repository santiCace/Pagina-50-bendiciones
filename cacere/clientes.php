<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
            <h1>50 BENDICIONES</h1>
            <p>Lista de Clientes registrados</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="clientes.php" class="active">Ver Clientes</a></li>
                <li><a href="agregarCliente.php">Agregar Cliente</a></li>
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
                    $sql = "DELETE FROM clientes WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $result = $stmt->execute([':id' => $id]);
                    
                    if ($result && $stmt->rowCount() > 0) {
                        $message = '✅ Cliente eliminado exitosamente.';
                        $messageType = 'success';
                    } else {
                        $message = '⚠️ No se encontró el cliente a eliminar.';
                        $messageType = 'warning';
                    }
                } catch (PDOException $e) {
                    $message = '❌ Error al eliminar cliente: ' . $e->getMessage();
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
                    <h2>👥 Lista de Clientes</h2>
                    <a href="agregarClientes.php" class="btn primary">
                        <span>➕</span> Nuevo Cliente
                    </a>
                </div>

                <!-- Formulario de búsqueda -->
                <div class="search-section">
                    <form method="GET" action="clientes.php" class="search-form">
                        <input 
                            type="text" 
                            name="buscar" 
                            placeholder="Buscar por Nombre o Cuil..." 
                            value="<?php echo htmlspecialchars($buscar); ?>"
                            class="search-input"
                        >
                        <button type="submit" class="btn secondary">
                            <span>🔍</span> Buscar
                        </button>
                        <?php if (!empty($buscar)): ?>
                            <a href="clientes.php" class="btn outline">
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
                        $sql = "SELECT * FROM clientes WHERE nombrec LIKE :buscar OR cuil LIKE :buscar ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':buscar' => "%$buscar%"]);
                        echo "<p class='search-info'>🔍 Resultados para: <strong>" . htmlspecialchars($buscar) . "</strong></p>";
                    } else {
                        $sql = "SELECT * FROM clientes ORDER BY fecha_registro DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }
                    
                    $clientes = $stmt->fetchAll();
                    $totalClientes = count($clientes);
                    
                    if ($totalClientes > 0) {
                        echo "<p class='users-count'>📊 Total de clientes: <strong>$totalClientes</strong></p>";
                        
                        echo "<div class='table-responsive'>";
                        echo "<table class='users-table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Nombre</th>";
                        echo "<th>Cuil</th>";
                        echo "<th>Telefono</th>";
                        echo "<th>Fecha Registro</th>";
                        echo "<th>Acciones</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        foreach ($clientes as $Cliente) {
                            $fechaFormateada = date('d/m/Y H:i', strtotime($Cliente['fecha_registro']));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($Cliente['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($Cliente['nombrec']) . "</td>";
                            echo "<td>" . htmlspecialchars($Cliente['cuil']) . "</td>";
                            echo "<td>" . htmlspecialchars($Cliente['telefonoc']) . "</td>";
                            echo "<td>" . $fechaFormateada . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='clientes.php?eliminar=" . $Cliente['id'] . "' ";
                            echo "class='btn danger btn-small' ";
                            echo "onclick='return confirm(\"¿Estás seguro de eliminar a " . htmlspecialchars($Cliente['Cuit']) . "?\");'>";
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
                            echo "<p>No hay clientes que coincidan con '<strong>" . htmlspecialchars($buscar) . "</strong>'</p>";
                            echo "<a href='clientes.php' class='btn secondary'>Ver todos los clientes</a>";
                            echo "</div>";
                        } else {
                            echo "<div class='empty-state'>";
                            echo "<div class='empty-icon'>👥</div>";
                            echo "<h3>No hay clientes registrados</h3>";
                            echo "<p>Comienza agregando tu primer cliente</p>";
                            echo "<a href='agregarClientes.php' class='btn primary'>Agregar primer cliente</a>";
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
            <p>&copy; Desde 2025 hasta el dia de hoy. </p>
        </footer>
    </div>

    <script>
        // Confirmar eliminación con JavaScript
        function confirmarEliminacion(nombrec, id) {
            if (confirm('¿Estás seguro de eliminar a ' + nombrec + '?')) {
                window.location.href = 'clientes.php?eliminar=' + id;
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
        <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">   
        <h1>50 BENDICIONES</h1>
            <p>Aplicación para organizar nuestra causa</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php" class="active">Inicio</a></li>
                <li><a href="agregarUsuario.php">Agregar Usuario</a></li>
                <li><a href="agregarEmpleados.php">Agregar Empleado</a></li>
                <li><a href="agregarCliente.php">Agregar Cliente</a></li>
                
            </ul>
        </nav>

        <main>
            <?php
            require_once 'config/database.php';
            
            // Intentar inicializar la base de datos
            $initResult = initializeDatabase();
            if ($initResult !== true) {
                echo "<div class='alert error'>$initResult</div>";
            }
            ?>

            <div class="welcome-section">
                <h2>Bienvenido a nuestra pagina</h2>
                <p>Aqui podran unirse a nuestra causa de traer la paz la cual los rusos nos la arrebataron hace años.</p>
                
                <div class="features">
                    <h3>Características:</h3>
                    <ul>
                        <li>✨ Asegure su lugar en nuestra organizacion</li>
                        <li>📋 Buscando exiliar a los Rusos de nuestro pais</li>
                        <li>❌ no nos haremos cargo de la segurirdad de los residentes ni de los epleados.</li>
                    </ul>
                </div>

                <div class="quick-actions">
                    <h3></h3>
                    <div class="actions-grid">
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy;  Desde 2025 hasta el dia de hoy.</p>
        </footer>
    </div>
</body>
</html>
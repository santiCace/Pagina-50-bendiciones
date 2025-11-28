<?php
Require_once 'config/database.php';

$pdo = getConnection();

$id = intval($_GET['id']);
$message = '';
$messageType = '';

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT * FROM trabajoinconcluso WHERE id = :id");
$stmt->execute([':id' => $id]);
$trabajoinconcluso = $stmt->fetch();

// Si se envió el formulario
If ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postal = trim($_POST['postales']);
    $direccion = trim($_POST['direcciones']);
    $telefono = trim($_POST['telefonoss']);
    $empleadoss = trim($_POST['empleadosss']);

    if (empty($postales) || empty($direcciones) || empty($telefonoss)) {
        $message = 'Las postales, las direcciones y el telefonoss son obligatorios.';
        $messageType = 'error';
    } else {
        $sql = "UPDATE trabajoinconcluso SET postales = :postales, direcciones = :direcciones, telefonoss = :telefonoss, empleadosss = :empleadosss WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $ok = $stmt->execute([
            ':postales' => $postales,
            ':direcciones' => $direcciones,
            ':telefonoss' => $telefonoss,
            ':empleadosss'=> $empleadosss,
            ':id' => $id
        ]);

        If ($ok) {
            $message = "✅ Trabajo modificado correctamente.";
            $messageType = "success";

            // Volver a cargar los datos actualizados
            $stmt = $pdo->prepare("SELECT * FROM trabajoinconcluso WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $trabajoinconcluso = $stmt->fetch();
        } else {
            $message = "❌ Ocurrió un error al actualizar.";
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - 50 BENDICIONES</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <header>
        <img src="image/logo oficial NEGRO.png" alt="Logo" class="logo">
        <h1>50 BENDICIONES</h1>
        <p>Editar trabajo inconcluso</p>
    </header>

    <main>
        <?php if (empty($message)): ?>
            <div class="alert <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h2>✏️ Editar Trabajo inconsluso</h2>

            <form method="POST" class="user-form">
                <div class="form-group">
                    <label>postal</label>
                    <input
                        Type="number"
                        Name="postales"
                        Value="<?php echo htmlspecialchars($trabajoinconcluso['postales']); ?>"
                        Required
                    >
                </div>

                <div class="form-group">
                    <label>direcciones</label>
                    <input
                        Type="text"
                        Name="direcciones"
                        Value="<?php echo htmlspecialchars($trabajoinconcluso['direcciones']); ?>"
                        Required
                    >
                </div>

                <div class="form-group">
                    <label>telefonoss</label>
                    <input
                        Type="number"
                        Name="telefonoss"
                        Value="<?php echo htmlspecialchars($trabajoinconcluso['telefonoss']); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Empleadosss</label>
                    <input
                        Type="text"
                        Name="empleadosss"
                        Value="<?php echo htmlspecialchars($trabajoinconcluso['empleadosss']); ?>"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">
                        💾 Guardar Cambios
                    </button>
                    <a href="trabajoinconcluso.php" class="btn secondary">⬅️ Volver</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p> Desde 2025 hasta el dia de hoy. </p>
    </footer>
</div>

</body>
</html>
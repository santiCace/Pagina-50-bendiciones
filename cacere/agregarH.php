<?php
Require_once 'config/database.php';

$pdo = getConnection();

$id = intval($_GET['id']);
$message = '';
$messageType = '';

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT * FROM trabajohecho WHERE id = :id");
$stmt->execute([':id' => $id]);
$trabajohecho = $stmt->fetch();

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postal = trim($_POST['postal']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $empleadoss = trim($_POST['empleadoss']);

    if (empty($postal) || empty($direccion) || empty($telefono)) {
        $message = 'La postal, la direccion y el telefono son obligatorios.';
        $messageType = 'error';
    } else {
        $sql = "UPDATE trabajoshecho SET postal = :postal, direccion = :direccion, telefono = :telefono, empleadoss = :empleadoss WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $ok = $stmt->execute([
            ':postal' => $postal,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':empleadoss'=> $empleadoss,
            ':id' => $id
        ]);

        If ($ok) {
            $message = "✅ Trabajo modificado correctamente.";
            $messageType = "success";

            // Volver a cargar los datos actualizados
            $stmt = $pdo->prepare("SELECT * FROM trabajohecho WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $trabajohecho = $stmt->fetch();
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
        <p>Editar trabajo hecho</p>
    </header>

    <main>
        <?php if (empty($message)): ?>
            <div class="alert" <?php echo $messageType; ?>>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h2>✏️ Editar Trabajo hecho</h2>

            <form method="POST" class="user-form">
                <div class="form-group">
                    <label>postal</label>
                    <input
                        Type="number"
                        Name="postal"
                        Value="<?php echo htmlspecialchars($trabajohecho['postal']); ?>"
                        Required
                    >
                </div>

                <div class="form-group">
                    <label>direccion</label>
                    <input
                        Type="text"
                        Name="direccion"
                        Value="<?php echo htmlspecialchars($trabajohecho['direccion']); ?>"
                        Required
                    >
                </div>

                <div class="form-group">
                    <label>telefono</label>
                    <input
                        Type="number"
                        Name="telefono"
                        Value="<?php echo htmlspecialchars($trabajohecho['telefono']); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Empleadoss</label>
                    <input
                        Type="text"
                        Name="empleadoss"
                        Value="<?php echo htmlspecialchars($trbajohecho['empleadoss']); ?>"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">
                        💾 Guardar Cambios
                    </button>
                    <a href="trabajohecho.php" class="btn secondary">⬅️ Volver</a>
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
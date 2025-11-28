<?php
Session_start();
Require_once "config/database.php";

If (¡isset($_SESSION["user_id"])) {
    Header("Location: login.php");
    Exit;
}

$pdo = getConnection();
$message = "";

If ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newpass = trim($_POST["newpass"]);

    If (empty($newpass)) {
        $message = "La contraseña no puede estar vacía.";
    } else {
        $hash = password_hash($newpass, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE usuarios_login SET password = ? WHERE id = ?");
        $stmt->execute([$hash, $_SESSION["user_id"]]);

        $message = "Contraseña actualizada correctamente.";
    }
}
?>

<h2>Cambiar contraseña</h2>
<form method=”POST”>
    <input type="password" name="newpass" placeholder="Nueva contraseña" required>
    <button type="submit">Guardar contraseña</button>
</form>

<div><?php echo $message ?></div>

<a href="index.php">Volver</a>
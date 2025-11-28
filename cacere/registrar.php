<?php
Require_once "config/database.php";
$pdo = getConnection();

$message = "";

If ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    If (empty($email) || empty($password)) {
        $message = "Todos los campos son obligatorios.";
    } else {
        // Encriptar contraseña
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO usuarios_login (email, password) VALUES (?, ?)");
        $ok = $stmt->execute([$email, $hash]);

        If ($ok) {
            Header("Location: login.php");
            Exit;
        } else {
            $message = "Error: ese correo ya está registrado.";
        }
    }
}
?>

<form method="POST">
    <h2>Registrar usuario</h2>
    <input type="email" name="email" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Registrar</button>
    <div><?php echo $message ?></div>
</form>

<?php
Session_start();
Require_once "config/database.php";
$pdo = getConnection();

$error = "";

If ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM usuarios_login WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    If ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        Header("Location: index.php");
        Exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<h2>Iniciar sesión</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>

<div><?php echo $error; ?></div>

<a href="register.php">Crear una cuenta</a>

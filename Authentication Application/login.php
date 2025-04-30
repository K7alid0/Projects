<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: welcome.php");
        exit;
    } else {
        $error = "Invalid login credentials";
    }
}
?>

<h2>Login</h2>
<form method="post">
    Email: <input name="email" type="email" required><br>
    Password: <input name="password" type="password" required><br>
    <button type="submit">Login</button>
</form>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
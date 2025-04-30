<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $errors = [];

    if (strlen($username) < 3) $errors[] = "Username too short";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email";
    if (strlen($password) < 6) $errors[] = "Password too short";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = "Email already registered";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);
            echo "Registration successful. <a href='login.php'>Login</a>";
            exit;
        }
    }
}
?>

<h2>Register</h2>
<form method="post">
    Username: <input name="username" required><br>
    Email: <input name="email" type="email" required><br>
    Password: <input name="password" type="password" required><br>
    <button type="submit">Register</button>
</form>

<?php if (!empty($errors)) foreach ($errors as $e) echo "<p style='color:red'>$e</p>"; ?>
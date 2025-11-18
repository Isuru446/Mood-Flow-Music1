<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($password !== $password2) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif (empty($username)) {
        $error = 'Choose a username';
    } else {
        // check existing
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Username already taken';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $ins->execute([$username, $email ?: null, $hash]);
            $id = $pdo->lastInsertId();
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Register</h1>
    <div style="margin-bottom:12px">
        <a class="btn btn-ghost" href="#" onclick="history.back();return false;">Back</a>
        <a class="btn" href="index.php">Home</a>
    </div>
    <?php if (!empty($error)) echo '<p style="color:#b71c1c">'.htmlspecialchars($error).'</p>'; ?>
    <div class="form-panel">
        <form method="post" action="register.php">
            <div><label>Username: <input type="text" name="username" required></label></div>
            <div style="margin-top:8px"><label>Email (optional): <input type="text" name="email"></label></div>
            <div style="margin-top:8px"><label>Password: <input type="password" name="password" required></label></div>
            <div style="margin-top:8px"><label>Repeat Password: <input type="password" name="password2" required></label></div>
            <div class="form-actions"><button class="btn" type="submit">Create account</button> <a class="admin-link" href="login.php">Login</a></div>
        </form>
    </div>
</div>
</body>
</html>

<?php
require_once 'connection.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sari Sari Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-slate-800 p-8 rounded-xl shadow-2xl w-96 border border-slate-700">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Sari Sari Store Login</h2>
        <?php if($error): ?><div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-slate-400 text-sm mb-2">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="mb-6">
                <label class="block text-slate-400 text-sm mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 rounded transition">Login</button>
        </form>
        <p class="mt-4 text-center text-sm text-slate-400">Don't have an account? <a href="register.php" class="text-emerald-400 hover:underline">Register</a></p>
    </div>
</body>
</html>

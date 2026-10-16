<?php
require_once 'connection.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username already taken.";
        } else {
            // Hash password securely as required
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'staff')");
            if ($stmt->execute([$username, $hashed_password])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong.";
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Sari Sari Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-slate-800 p-8 rounded-xl shadow-2xl w-96 border border-slate-700">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Create Account</h2>
        <?php if($error): ?><div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm"><?= $error ?></div><?php endif; ?>
        <?php if($success): ?><div class="bg-green-500/20 text-green-400 p-3 rounded mb-4 text-sm"><?= $success ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-slate-400 text-sm mb-2">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="mb-6">
                <label class="block text-slate-400 text-sm mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 rounded transition">Register</button>
        </form>
        <p class="mt-4 text-center text-sm text-slate-400">Already have an account? <a href="login.php" class="text-emerald-400 hover:underline">Login</a></p>
    </div>
</body>
</html>

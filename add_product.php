<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = trim($_POST['product_name']);
    $stock = intval($_POST['stock']);
    $price = floatval($_POST['price']);

    if (!empty($product_name) && $stock >= 0 && $price >= 0) {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, stock, price) VALUES (?, ?, ?)");
        if ($stmt->execute([$product_name, $stock, $price])) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Failed to add product.";
        }
    } else {
        $error = "Please provide valid product details.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Sari Sari Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-slate-800 p-8 rounded-xl shadow-2xl w-full max-w-md border border-slate-700">
        <h2 class="text-2xl font-bold text-white mb-6">Add New Product</h2>
        <?php if($error): ?><div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-slate-400 text-sm mb-2">Product Name</label>
                <input type="text" name="product_name" required class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="mb-4">
                <label class="block text-slate-400 text-sm mb-2">Stock Quantity</label>
                <input type="number" name="stock" required min="0" class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="mb-6">
                <label class="block text-slate-400 text-sm mb-2">Price (₱)</label>
                <input type="number" step="0.01" name="price" required min="0" class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-2 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="flex justify-end gap-3">
                <a href="index.php" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded text-sm font-medium">Cancel</a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded text-sm font-medium">Save Product</button>
            </div>
        </form>
    </div>
</body>
</html>

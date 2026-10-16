<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch metrics
$totalSales = $pdo->query("SELECT SUM(total_amount) FROM transactions")->fetchColumn() ?: 0;
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() ?: 0;
$lowStockCount = $pdo->query("SELECT COUNT(*) FROM products WHERE stock < 10")->fetchColumn() ?: 0;

// Fetch products for inventory table
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overview | Sari Sari Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex h-screen overflow-hidden font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="p-5 font-bold text-lg text-white border-b border-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-store text-emerald-400"></i> Sari Sari Store
            </div>
            <nav class="p-4 space-y-2 text-sm">
                <a href="index.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white font-medium"><i class="fa-solid fa-chart-pie"></i> Overview</a>
                <a href="#inventory" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition"><i class="fa-solid fa-boxes-stacked"></i> Inventory</a>
                <a href="logout.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-red-500/20 hover:text-red-400 transition mt-10"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800 text-xs text-slate-500">
            Logged in as: <span class="text-white font-semibold"><?= htmlspecialchars($_SESSION['username']) ?></span>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white border-b border-slate-200 p-4 flex justify-between items-center shadow-sm">
            <h1 class="text-xl font-bold text-slate-800">Overview</h1>
            <div class="flex items-center gap-4">
                <a href="add_product.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow transition">
                    <i class="fa-solid fa-plus"></i> Add Product
                </a>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <!-- KPI Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-emerald-600 text-white p-6 rounded-xl shadow-md">
                    <p class="text-emerald-100 text-sm font-medium">Total Sales</p>
                    <h3 class="text-3xl font-bold mt-2">₱<?= number_format($totalSales, 2) ?></h3>
                </div>
                <div class="bg-blue-600 text-white p-6 rounded-xl shadow-md">
                    <p class="text-blue-100 text-sm font-medium">Total Items / Products</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $totalProducts ?></h3>
                </div>
                <div class="bg-amber-600 text-white p-6 rounded-xl shadow-md">
                    <p class="text-amber-100 text-sm font-medium">Low Stock Alerts</p>
                    <h3 class="text-3xl font-bold mt-2"><?= $lowStockCount ?></h3>
                </div>
            </div>

            <!-- Inventory Table Section (CRUD Read & Actions) -->
            <div id="inventory" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Store Inventory Management</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                                <th class="p-4">Product Name</th>
                                <th class="p-4">Stock</th>
                                <th class="p-4">Price</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $p): ?>
                                <tr>
                                    <td class="p-4 font-medium text-slate-900"><?= htmlspecialchars($p['product_name']) ?></td>
                                    <td class="p-4"><?= $p['stock'] ?> units</td>
                                    <td class="p-4">₱<?= number_format($p['price'], 2) ?></td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $p['stock'] < 10 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' ?>">
                                            <?= $p['stock'] < 10 ? 'Low Stock' : 'In Stock' ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <a href="edit_product.php?id=<?= $p['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="text-red-600 hover:text-red-800 font-medium"><i class="fa-solid fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-400">No products found in inventory. Click "Add Product" to get started.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

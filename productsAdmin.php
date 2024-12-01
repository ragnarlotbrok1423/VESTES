<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Productos</title>
</head>

<body class="w-screen bg-[#f0f0f0]">
    <aside class="w-64 bg-principalColor text-white p-6 min-h-screen">
        <div class="pb-12 mt-3">
            <a class="text-4xl text-white font-gokhan" href="login.php">VESTES</a>
        </div>
        <div class="pb-12">
            <h1><?php echo htmlspecialchars($_SESSION['user']['name']) ?></h1>
            <h1><?php echo htmlspecialchars($_SESSION['user']['email']) ?></h1>
        </div>
        <nav>
            <ul class="space-y-2">
                <li><a href="adminView.php" class="block py-2 px-4 hover:bg-pointColor rounded">Usuarios</a></li>
                <li><a href="productsAdmin.php" class="block py-2 px-4 hover:bg-pointColor rounded">Productos</a></li>

            </ul>
        </nav>
    </aside>
</body>

</html>
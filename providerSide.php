<?php


if (!isset($_SESSION['provider'])) {
    header('Location: providerLogin.php');
    exit;
}


?>
<aside class="w-64 bg-principalColor text-white p-6 min-h-screen">
    <div class="pb-12 mt-3">
        <a class="text-4xl text-white font-gokhan" href="login.php">VESTES</a>
    </div>
    <div class="pb-12">
        <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($_SESSION['provider']['name']) ?></h1>
        <p class="text-sm"><?php echo htmlspecialchars($_SESSION['provider']['email']) ?></p>
        <p class="text-sm">Proveedor N <?php echo htmlspecialchars($_SESSION['provider']['idProvider']) ?></p>

    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="providerAdmin.php" class="block py-2 px-4 hover:bg-pointColor rounded">Ventas</a></li>
            <li><a href="providerProducts.php" class="block py-2 px-4 hover:bg-pointColor rounded">Ver Productos</a>
            </li>

            <li> <a href="logout.php" class="block py-2 px-4 hover:bg-pointColor rounded">Cerrar Sesion</a></li>

        </ul>
    </nav>
</aside>
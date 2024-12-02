<?php


if (!isset($_SESSION['user'])) {
    header('Location: loginAdmin.php');
    exit;
}

?>
<aside class="w-64 bg-principalColor text-white p-6 min-h-screen">
    <div class="pb-12 mt-3">
        <a class="text-4xl text-white font-gokhan" href="login.php">VESTES</a>
    </div>
    <div class="pb-12">
        <h1><?php echo htmlspecialchars($_SESSION['user']['user']) ?></h1>
    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="adminView.php" class="block py-2 px-4 hover:bg-pointColor rounded">Usuarios</a></li>
            <li><a href="addProduct.php" class="block py-2 px-4 hover:bg-pointColor rounded">Agnadir Productos</a></li>
            <li><a href="productView.php" class="block py-2 px-4 hover:bg-pointColor rounded">Ver Productos</a></li>
            <li><a href="providerView.php" class="block py-2 px-4 hover:bg-pointColor rounded">Provedores</a></li>
            <li><a href="sales.php" class="block py-2 px-4 hover:bg-pointColor rounded">Ventas</a></li>
            <li> <a href="logout.php" class="block py-2 px-4 hover:bg-pointColor rounded">Cerrar Sesion</a></li>

        </ul>
    </nav>
</aside>
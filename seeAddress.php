<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>SeeAddress</title>
</head>
<body class="h-screen  bg-[#f0f0f0] ">
<div class="flex h-full">
    <!-- Sidebar -->
    <aside class="w-64 bg-principalColor text-white p-6">
        <h2 class="text-2xl font-bold mb-6">Menú</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="seeAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Ver direcciones</a></li>
                <li><a href="addAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Añadir dirección</a></li>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-complementary rounded">volver</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 px-10  my-10 ">
        <h1 class="text-3xl font-bold mb-6 text-darkColor">Direcciones</h1>
        <div class="grid grid-cols-1  sm:px-7  lg:grid-cols-3 gap-6">
            <!-- Tarjetas -->
            <!-- Tarjeta de dirección 1 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-2 text-darkColor">Casa</h3>
                <p class="text-gray-600 mb-1">Ciudad: Madrid</p>
                <p class="text-gray-600 mb-4">País: España</p>
                <p class="text-gray-600 mb-4">Dirección: Activa</p>

                <button class="bg-pointColor text-white py-2 px-4 rounded hover:bg-red-700 transition duration-300">Hacer Activa</button>
            </div>

            <!-- Tarjeta de dirección 2 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-2 text-darkColor">Oficina</h3>
                <p class="text-gray-600 mb-1">Ciudad: Barcelona</p>
                <p class="text-gray-600 mb-4">País: España</p>
                <p class="text-gray-600 mb-4">Dirección: Activa</p>

                <button class="bg-pointColor text-white py-2 px-4 rounded hover:bg-red-700 transition duration-300">Hacer Activa</button>
            </div>

            <!-- Tarjeta de dirección 3 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-2 text-darkColor">Vacaciones</h3>
                <p class="text-gray-600 mb-1">Ciudad: París</p>
                <p class="text-gray-600 mb-4">País: Francia</p>
                <p class="text-gray-600 mb-4">Dirección: Activa</p>

                <button class="bg-pointColor text-white py-2 px-4 rounded hover:bg-red-700 transition duration-300">Hacer Activa</button>
            </div>
        </div>
    </main>
</div>
</body>

</html>

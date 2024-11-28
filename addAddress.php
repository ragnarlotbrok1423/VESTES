<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>AddAdrress</title>
</head>
<body class="bg-[#f0f0f0] h-screen ">
<div class="flex min-h-screen">
<!-- Sidebar -->
<aside class="w-64 h-96  bg-principalColor text-white p-6">
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
<main class="flex-1 px-10 ">
    <h1 class="text-3xl font-bold mb-6 text-darkColor mt-10">Añadir Nueva Dirección</h1>
    <form class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <div class="mb-4">
            <label for="name" class="block text-darkColor font-semibold mb-2">Nombre de la dirección</label>
            <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor" required>
        </div>
        <div class="mb-4">
            <label for="street" class="block text-darkColor font-semibold mb-2">Ciudad</label>
            <input type="text" id="street" name="street" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor" required>
        </div>

        <div class="mb-6">
            <label for="country" class="block text-darkColor font-semibold mb-2">País</label>
            <select id="country" name="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor" required>
                <option value="">Selecciona un país</option>
                <option value="ES">España</option>
                <option value="FR">Francia</option>
                <option value="DE">Alemania</option>
                <option value="IT">Italia</option>
                <option value="UK">Reino Unido</option>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-pointColor text-white py-2 px-6 rounded-md hover:bg-red-700 transition duration-300">Guardar Dirección</button>
        </div>
    </form>
</main>
</div>
</body>
</html>

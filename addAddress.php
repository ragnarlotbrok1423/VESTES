<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$xmlFile = 'paises.xml';

$xml = simplexml_load_file($xmlFile) or die("Error al cargar el archivo XML.");


function generateCountrySelect($countries)
{
    echo '<select name="country" id="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor" required>';
    echo '<option value="">Selecciona un país</option>';
    foreach ($countries as $country) {
        echo '<option value="' . htmlspecialchars($country->Id) . '">' . htmlspecialchars($country->Nombre) . '</option>';
    }
    echo '</select>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user']['id'];
    $nameAddress = $_POST['name_address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    $apiUrl = "http://localhost/ApiRest/Address/create";
    $data = json_encode([
        'user_id' => $userId,
        'name_address' => $nameAddress,
        'city' => $city,
        'country' => $country
    ]);

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        echo "Error al añadir la dirección.";
    }

    // Redirigir después de realizar la acción
    header('Location: seeAddress.php');
    exit;
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>AddAdrress</title>
</head>

<body class="bg-[#f0f0f0]">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64   bg-principalColor text-white p-6 min-h-screen">
            <h2 class="text-2xl font-bold mb-6">Menú</h2>
            <nav>
                <ul class="space-y-2">
                    <li><a href="seeAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Ver
                            direcciones</a></li>
                    <li><a href="addAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Añadir
                            dirección</a></li>
                    <li><a href="index.php" class="block py-2 px-4 hover:bg-complementary rounded">volver</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 px-10 ">
            <h1 class="text-3xl font-bold mb-6 text-darkColor mt-10">Añadir Nueva Dirección</h1>
            <form class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto" method="POST" action="">
                <div class="mb-4">
                    <label for="name" class="block text-darkColor font-semibold mb-2">Nombre de la dirección</label>
                    <input type="text" id="name_address" name="name_address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor"
                        required>
                </div>
                <div class="mb-4">
                    <label for="street" class="block text-darkColor font-semibold mb-2">Ciudad</label>
                    <input type="text" id="city" name="city"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-principalColor"
                        required>
                </div>

                <div class="mb-6">
                    <label for="country" class="block text-darkColor font-semibold mb-2">País</label>
                    <?php generateCountrySelect($xml->children()); ?>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-pointColor text-white py-2 px-6 rounded-md hover:bg-red-700 transition duration-300">Guardar
                        Dirección</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
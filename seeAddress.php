<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

function getAddressFromAPI()
{
    $userId = $_SESSION['user']['id'];
    $apiUrl = "http://localhost/apirest/address/getByUser/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener las direcciones de la API";
        return [];
    }

    return json_decode($response, true);
}

$addresses = getAddressFromAPI();

$xmlFile = 'paises.xml';
$xml = simplexml_load_file($xmlFile) or die("Error al cargar el archivo XML.");
function getCountryNameById($countryId, $xml) {
    foreach ($xml->Item as $country) {
        if ((int)$country->Id === (int)$countryId) {
            return (string)$country->Nombre;
        }
    }
    return '';  
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>SeeAddress</title>
</head>
<body class="h-screen bg-[#f0f0f0]">
<div class="flex h-full">
    <!-- Sidebar -->
    <aside class="w-64 bg-principalColor text-white p-6">
        <h2 class="text-2xl font-bold mb-6">Menú</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="seeAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Ver direcciones</a></li>
                <li><a href="addAddress.php" class="block py-2 px-4 hover:bg-complementary rounded">Añadir dirección</a></li>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-complementary rounded">Volver</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 px-10 my-10">
    <h1 class="text-3xl font-bold mb-6 text-darkColor">Direcciones</h1>
    <div class="grid grid-cols-1 sm:px-7 lg:grid-cols-3 gap-6">
                    <?php
            usort($addresses, function($a, $b) {
                return ($a['isActive'] == '1') ? -1 : 1;
            });
            ?>
        <?php if (!empty($addresses)): ?>
            <?php foreach ($addresses as $address): ?>              
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-2 text-darkColor"><?php echo htmlspecialchars($address['name_address']); ?></h3>
                    <p class="text-gray-600 mb-1">Ciudad: <?php echo htmlspecialchars($address['city']); ?></p>
                    <?php $countryName = getCountryNameById($address['country'], $xml); ?>
                    <p>País: <?php echo htmlspecialchars($countryName); ?></p>
                    <p><?php echo $address['isActive'] == '1' ? 'Dirección activa' : 'Dirección inactiva'; ?></p>

                    <?php if ($address['isActive'] != '1'): ?>
                        <form method="POST" action="AdressCRUD.php">
                            <input type="hidden" name="address_id" value="<?php echo $address['idAdress']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <button type="submit" class="bg-pointColor text-white py-2 px-4 rounded hover:bg-red-700 transition duration-300">Hacer Activa</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">No tienes direcciones registradas.</p>
        <?php endif; ?>
    </div>
    </main>
</div>
</body>
</html>

<?php
session_start();

//Seccion para hacer activa una direccion
if (!isset($_SESSION['user']['id'])) {
    // Redirigir a login.php si no ha iniciado sesión
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['address_id'])) {
    $userId = $_SESSION['user']['id'];
    $addressId = $_POST['address_id'];

    $apiUrl = "http://localhost/apirest/address/makeActive";
    $data = json_encode([
        'address_id' => $addressId,
        'user_id' => $userId
    ]);

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        echo "Error al activar la dirección.";
    }

    // Redirigir después de realizar la acción para evitar duplicación de solicitudes POST
    header('Location: seeAddress.php');
    exit;
}
////////////////////////////


//Seccion para anadir una direccion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name_address'])) {
    $userId = $_SESSION['user']['id'];
    $nameAddress = $_POST['name_address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    $apiUrl = "http://localhost/apirest/Address/create";
    $data = json_encode([
        'user_id' => $userId,
        'name_address' => $nameAddress,
        'city' => $city,
        'country' => $country
    ]);

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
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
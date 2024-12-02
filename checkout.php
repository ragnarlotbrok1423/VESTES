<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user']['id'];
$id = $userId;

// URL de la API para crear la orden
$apiUrl = "http://localhost/ApiRest/Order/create/$id";

$ch = curl_init($apiUrl);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POST, true); 

// Ejecuta la solicitud
$response = curl_exec($ch);

if (curl_errno($ch)) {
    $_SESSION['message'] = "Error en la solicitud: " . curl_error($ch);
    $_SESSION['message_type'] = "error";
} else {
    
    if ($response) {
        $_SESSION['message'] = "Compra realizada con éxito.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al realizar la compra.";
        $_SESSION['message_type'] = "error";
    }
}


curl_close($ch);

header("Location: cart.php");
exit;
?>

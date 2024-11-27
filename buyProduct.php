<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    // Redirigir a login.php si no ha iniciado sesión
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

 
    $apiUrl = 'http://localhost/apirest/Cart/create';


    $data = [
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity
    ];

   
    $jsonData = json_encode($data);

  
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $jsonData
        ]
    ];

    $context = stream_context_create($options);

   
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        die('Error al agregar el producto al carrito.');
    }

    header('Location: index.php?message=Producto agregado al carrito.');
    exit;
}
?>

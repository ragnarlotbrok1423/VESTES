<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];

    $data = [
        'user_id' => $userId,
        'product_id' => $productId
    ];

    
    $jsonData = json_encode($data);

   
    $ch = curl_init("http://localhost/apirest/Cart/delete");

    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);

    $response = curl_exec($ch);

    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    
    curl_close($ch);

    // Redirigir al carrito de nuevo después de eliminar el producto
    header('Location: cart.php');
    exit;
}
?>

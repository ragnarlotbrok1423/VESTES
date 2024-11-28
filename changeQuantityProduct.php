<?php

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $data = [
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity
    ];

    $jsonData = json_encode($data);

    $ch = curl_init("http://localhost/ApiRest/Cart/update");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    header('Location: cart.php');
    exit;
}
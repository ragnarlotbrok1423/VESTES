<?php
session_start();
$apiUrl = 'http://localhost/ApiRest/Costumer/login';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode([
            'email' => $email,
            'password' => $password
        ])
    ]);

   
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);

    if (isset($data['success']) && $data['success'] === true) {
       
        $_SESSION['user'] = [
            'id' => $data['id'],       
            'name' => $data['name'],   
            'email' => $data['email']  
        ];

        
        header('Location: ../VESTES/index.php');
        exit;
    } else {
        echo "Error: " . ($data['message'] ?? 'Credenciales incorrectas.');
        exit;
    }
} else {
    echo "Error al conectar con la API.";
    exit;
}
}
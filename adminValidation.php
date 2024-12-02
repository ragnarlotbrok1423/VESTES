<?php
session_start();
$apiUrl = 'http://localhost/ApiRest/admin/login';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $user = $_POST['user'] ?? null;
    $password = $_POST['password'] ?? null;
    

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode([
            'user' => $user,
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
            'id' => $data['idAdmin'],       
            'user' => $data['user']
        ];

        
        header('Location: ../VESTES/adminView.php');
        exit;
    } else {
          header('Location: loginAdmin.php?error=1');
            exit;
    }
} else {
    header('Location: loginAdmin.php?error=2');
        exit;
}
}
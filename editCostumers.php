<?php
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cellphone = $_POST['cellphone'];

    $apiUrl = "http://localhost/ApiRest/costumer/update";


    $data = [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'cellphone' => $cellphone
    ];


    $jsonData = json_encode($data);


    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $jsonData
        ]
    ];

    $context = stream_context_create($options);


    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        die('Error al Actualizar al usuario');
    }

    header('Location: adminview.php?message=UsuarioActualizado.');
    exit;
}
?>
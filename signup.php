<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Verificar que las contraseñas coinciden
    if ($password !== $confirmPassword) {
        die('Las contraseñas no coinciden.');
    }

    // Crear un array con los datos a enviar
    $data = array(
        'name' => $name,
        'email' => $email,
        'cellphone' => $cellphone,
        'password' => $password
    );

    // Inicializar cURL
    $ch = curl_init('http://localhost/ApiRest/Costumer/create');

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Convertir el array a JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar si hubo algún error con cURL
    if (curl_errno($ch)) {
        echo 'Error de cURL: ' . curl_error($ch);
    }

    // Cerrar la sesión cURL
    curl_close($ch);
    header('Location: ../VESTES/login.php');
}

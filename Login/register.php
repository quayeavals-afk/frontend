<?php
session_start();

$dbc = mysqli_connect('localhost', 'root', '', 'login');

// Получаем JSON данные от fetch
$data = json_decode(file_get_contents("php://input"), true);

if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];

// 1. Сначала проверяем, есть ли такой пользователь
$check_query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
$check_result = mysqli_query($dbc, $check_query);



if (mysqli_num_rows($check_result) > 0) {
    // Пользователь уже существует
    http_response_code(409);  // Conflict
    header('Content-Type: application/json');
    print json_encode(array('status' => 'error', 'message' => 'Такой аккаунт уже существует'));
} 




else {
    // 2. Если нет - регистрируем
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO login (username, email, password) 
        VALUES ('$username', '$email', '$hashed_password')";

    $result = mysqli_query($dbc, $query);

    if ($result) {
        http_response_code(201);
        header('Content-Type: application/json');
        print json_encode(array('status' => 'good', 'message' => 'Зарегистрировался'));
    } else {
        http_response_code(500);
        header('Content-Type: application/json');
        print json_encode(array('status' => 'error', 'message' => mysqli_error($dbc)));
    }
}

mysqli_close($dbc);
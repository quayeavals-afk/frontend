<?php
session_start();

$dbc = mysqli_connect('localhost', 'root', '', 'login'); // Подключаемся к базе


$username = $_POST['username'];  
$entered_password = $_POST['password'];


$query = "SELECT id, username, email, password FROM login WHERE username='$username'";
$result = mysqli_query($dbc, $query);

// 2. Проверяем, есть ли такой пользователь
if (mysqli_num_rows($result) == 0) {
    echo "Неверный логин или пароль1";
    exit;
} else{
    
    $user = mysqli_fetch_assoc($result);


    if (password_verify($entered_password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; 
        header('Location: ../index.php'); 
        exit;
    } 
}


mysqli_close($dbc);
?>
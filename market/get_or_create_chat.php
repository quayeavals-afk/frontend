<?php
require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId();

$id = isset($_GET['ad_id']) ? (int)$_GET['ad_id'] : 0;
$chat_id = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : 0; // Получаем chat_id из URL, если он есть иначе 0


if ($chat_id != 0) {
    // Если chat_id передан, просто перенаправляем на messenger.php с этим chat_id
    header("Location: messenger.php?ad_id=$id&chat_id=$chat_id");
    exit();
}

if ($id <= 0) {
    die("Ошибка: некорректный ID объявления");
}

// Подключаемся к базе данных
$dbc = mysqli_connect('localhost', 'root', '', 'market');

// Получаем информацию об объявлении
$query = "SELECT * FROM market WHERE id = $id";
$result = mysqli_query($dbc, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Ошибка: объявление с ID $id не найдено");
}

$ad = mysqli_fetch_assoc($result);
$seller_id = $ad['user_id']; // id продавца (владельца объявления)


// ПРОВЕРЯЕМ, ЧТО ПРОДАВЕЦ НАЙДЕН
if (!$seller_id) {
    die("Ошибка: у объявления нет владельца");
}

// Ищем существующий чат
$query_chat = "SELECT * FROM chats WHERE 
               ad_id = $id AND 
               ((buyer_id = $current_user_id AND seller_id = $seller_id) OR 
                (buyer_id = $seller_id AND seller_id = $current_user_id))";

$result_chat = mysqli_query($dbc, $query_chat);

if (!$result_chat) {
    die("Ошибка запроса чата: " . mysqli_error($dbc));
}

$existing_chat = mysqli_fetch_assoc($result_chat);













if ($existing_chat) {
    $chat_id = $existing_chat['id'];
} else {
    // Создаем новый чат
    $insert_chat_query = "INSERT INTO chats (ad_id, seller_id, buyer_id) 
                          VALUES ($id, $seller_id, $current_user_id)";
    
    if (mysqli_query($dbc, $insert_chat_query)) {
        $chat_id = mysqli_insert_id($dbc);
    } else {
        die("Ошибка создания чата: " . mysqli_error($dbc));
    }
}

mysqli_close($dbc);

header("Location: messenger.php?ad_id=$id&chat_id=$chat_id");
exit();
?>
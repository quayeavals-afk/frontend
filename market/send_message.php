<?php

// остальной код
// Получаем JSON из тела запроса
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true); // превращаем JSON в массив

// СНАЧАЛА проверяем, есть ли данные
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Нет данных']);
    exit;
}

// ПОТОМ проверяем поля
if (!isset($data['chat_id']) || !isset($data['sender_id']) || 
    !isset($data['message_text']) || !isset($data['sent_at'])) {
    echo json_encode(['status' => 'error', 'message' => 'Не все поля переданы']);
    exit;
}

// Теперь можешь использовать:
$chat_id = $data['chat_id'];
$sender_id = $data['sender_id'];
$message_text = $data['message_text'];
$sent_at = $data['sent_at'];
$is_read = $data['is_read'] ?? 0; // добавил значение по умолчанию

// Дальше сохраняешь в БД...
$dbc = mysqli_connect('localhost', 'root', '', 'market');

// Экранируем данные для безопасности
$chat_id = mysqli_real_escape_string($dbc, $chat_id);
$sender_id = mysqli_real_escape_string($dbc, $sender_id);
$message_text = mysqli_real_escape_string($dbc, $message_text);
$sent_at = mysqli_real_escape_string($dbc, $sent_at);
$is_read = mysqli_real_escape_string($dbc, $is_read);

$query = "INSERT INTO messages (chat_id, sender_id, message_text, sent_at, is_read) 
        VALUES ('$chat_id', '$sender_id', '$message_text', '$sent_at', '$is_read')";

$result = mysqli_query($dbc, $query);
if ($result) {
    echo json_encode(['status' => 'success', 'message_id' => mysqli_insert_id($dbc)]);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($dbc)]);
}
?>
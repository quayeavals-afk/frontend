<?php
// 1. Подключаемся к БД (это может ТОЛЬКО PHP)
header('Content-Type: application/json');

$dbc = mysqli_connect('localhost', 'root', '', 'market');

// 2. Получаем данные (SQL запрос)
$chat_id = (int)$_GET['chat_id'];
$query = "SELECT * FROM messages WHERE chat_id = $chat_id";
$result = mysqli_query($dbc, $query);

// 3. Превращаем в массив
$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// 4. Отдаем JS в формате JSON
echo json_encode($ads);
echo json_encode($messages);
?>
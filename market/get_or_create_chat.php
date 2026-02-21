<?php
require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя

$id = $_GET['ad_id'] ?? 0; // id объявления из URL

// 2. Подключаемся к базе данных
$dbc = mysqli_connect ('localhost', 'root', '', 'market');

$query = "SELECT * FROM market WHERE id = $id";
$result = mysqli_query($dbc, $query);
$ad = mysqli_fetch_assoc($result);// объявление

$seller_id = $ad['user_id']; // id продавца



$dbc = mysqli_connect ('localhost', 'root', '', 'market');

$query_seller = "SELECT * FROM chats WHERE 
                                    ad_id = $id and 
                                    seller_id = $seller_id AND 
                                    buyer_id = $current_user_id";

$result_seller = mysqli_query($dbc, $query_seller);


$ad2 = mysqli_fetch_assoc($result_seller); 
if ($ad2) {
    $chat_id = $ad2['id']; // id существующего чата
} else {
    // Если чат не найден, создаем новый
    $insert_chat_query = "INSERT INTO chats (ad_id, seller_id, buyer_id) 
                            VALUES ($id, $seller_id, $current_user_id)";
    mysqli_query($dbc, $insert_chat_query);
    $chat_id = mysqli_insert_id($dbc); // id нового чата
}
mysqli_close($dbc);

header("Location: messenger.php?ad_id=$id&chat_id={$chat_id }"); // перенаправляем на страницу чата с id объявления и id чата
exit(); // всегда ставь exit после header

?>
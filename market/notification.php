<?php
// notification.php
$dbc = mysqli_connect('localhost', 'root', '', 'market');
$user_id = mysqli_real_escape_string($dbc, $_GET['user_id']);

$query = "SELECT c.*, 
          (SELECT message_text FROM messages 
           WHERE chat_id = c.id 
           ORDER BY sent_at DESC LIMIT 1) as last_message_text,
          (SELECT is_read FROM messages 
           WHERE chat_id = c.id 
           ORDER BY sent_at DESC LIMIT 1) as last_message_is_read,
          (SELECT sender_id FROM messages 
           WHERE chat_id = c.id 
           ORDER BY sent_at DESC LIMIT 1) as last_message_sender_id
          FROM chats c 
          WHERE c.buyer_id = $user_id OR c.seller_id = $user_id";

$result = mysqli_query($dbc, $query);

$chats = [];
while ($row = mysqli_fetch_assoc($result)) {
    $chats[] = $row;
}

echo json_encode($chats);
?>
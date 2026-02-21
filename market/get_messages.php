<?php
// get_messages.php
$dbc = mysqli_connect('localhost', 'root', '', 'market');
$chat_id = (int)$_GET['chat_id'];
$current_user_id = (int)$_GET['user_id'];

$query = "SELECT * FROM messages WHERE chat_id = $chat_id ORDER BY sent_at ASC";
$result = mysqli_query($dbc, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($message = mysqli_fetch_assoc($result)) {
        $sender_id = $message['sender_id'];
        $message_text = $message['message_text'];
        $sent_at = substr($message['sent_at'], 10,6);
        
        $message_class = ($sender_id == $current_user_id) ? 'sent' : 'received';
        
        echo '<div class="message ' . $message_class . '">';
        echo '    <div class="message-content">';
        echo '        <p>' . htmlspecialchars($message_text) . '</p>';
        echo '        <span class="message-time">' . htmlspecialchars($sent_at) . '</span>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo '<p>Нет сообщений в этом чате.</p>';
}
?>
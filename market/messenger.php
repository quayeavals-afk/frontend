<?php
// ПЕРВАЯ строка в файле
require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя

$id = $_GET['ad_id'] ?? 0; // id объявления
$chat_id = $_GET['chat_id'] ?? 0; // id чата


$dbc = mysqli_connect ('localhost', 'root', '', 'market');

$query = "SELECT * FROM market WHERE id = $id";


$result = mysqli_query($dbc, $query); // выполняем запрос к базе данных для получения информации об объявлении по его id

if ($result && mysqli_num_rows($result) > 0) { // 
    $ad = mysqli_fetch_assoc($result); // извлекаем данные объявления в виде ассоциативного массива
    $seller_id = $ad['user_id']; // id продавца
    $seller_name = $ad['username']; // имя продавца
    $title = $ad['name']; // название товара
    $img = $ad['img']; // изображение товара
} 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messenger | <?php echo htmlspecialchars($id); ?> | FEFUchota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="header__left">
            <button class="more__button" id="more__button"></button>
            <p class="had__name">(я)<?php echo htmlspecialchars($current_user_id);?> (ты)<?php echo htmlspecialchars($seller_id);?> 
        <?php echo htmlspecialchars($chat_id); ?></p>
        </div>

        <div class="header__right">
            <button class="chats__button"></button>
            <section class="chats__window">
                <div class="chats__info">
                    <p>Чаты</p>
                </div>
                <div class="chats">
                    <ul>
                        <li class="#">123</li>
                        <li class="#">123</li>
                        <li class="#">123</li>
                        <li class="#">123</li>
                    </ul>
                </div>
            </section>
            
            <!-- Имя пользователя -->
            <p class="your__login">
                <?php 
                if ($username) {
                    echo htmlspecialchars($username);
                } else {echo 'Гость';}
                ?>
            </p>
            
            <!-- Кнопка Войти/Выйть -->
            <?php if ($username): ?>
                <!-- Если пользователь вошёл ($username не пустой) -->
                <a href="../Login/logout_page.php" class="logout__button">Выйти</a>
            <?php else: ?>
                <!-- Если пользователь НЕ вошёл ($username пустой) -->
                <a href="../Login/index.php" class="login__button"></a>
            <?php endif; ?>
        </div>
    </header>

    <section class="menu">
        <div id="sidebar">
            <div class="nav">
                <ul>
                    <li><a href="../index.php" > <p>главная</p> </a></li>
                    <li><a href="../Market/index.php"> <p>рыночек</p> <img src="../img/shopping-cart.svg"/> </a></li>
                    <li><a href="#"> <p>потеряшки</p> <img src="../img/hand-paper.svg"/> </a></li>
                    <li><a href="#"> <p>спорт</p> <img src="../img/ball.svg"/> </a></li>
                    <li><a href="#"> <p>соседи</p> <img src="../img/house.svg"/> </a></li>
                    <li><a href="#">  <p>доставка</p> <img src="../img/basket-shopping-simple.svg"/> </a></li>
                    <li><a href="#"> <p>попутчики</p> <img src="../img/car.svg"/> </a></li>
                    <div class="commercial">рекламо</div>
                </ul>
            </div>
        </div>
    </section>
    <!-- Основное содержание -->
    <section class="messenger">
        <!-- Шапка чата с информацией о собеседнике и товаре -->
        <div class="chat-header">
            <div class="chat-info">
                <img src="<?php echo htmlspecialchars($img);?>" alt="avatar" class="chat-avatar">
                <div class="chat-details">
                    <h2 class="chat-name"><?php echo htmlspecialchars($seller_name);?></h2>
                    <p class="chat-product">Объявление: <?php echo htmlspecialchars($title);?></p>
                </div>
            </div>
            <a href="javascript:history.back()" class="back-button">← Назад</a>
        </div>












        <!-- Область сообщений -->
        <div class="messages-container" id="messagesContainer">
        <script>
            // Функция загрузки сообщений
            function loadMessages() {
                fetch(`get_messages.php?chat_id=<?php echo $chat_id; ?>&user_id=<?php echo $current_user_id; ?>`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('messagesContainer').innerHTML = html;
                    });
            }
            loadMessages();
            setInterval(loadMessages, 1000);
        </script>

            <!-- Сообщения будут загружаться сюда -->
        </div>

        <!-- Форма отправки сообщения -->
        <div class="message-form">
            <div class="input-wrapper">
                <input type="text" 
                    class="message-input" 
                    id="messageInput"
                    placeholder="Напишите сообщение..."
                    autocomplete="off">
                <button class="attach-button" type="button" title="Прикрепить файл">
                    📎
                </button>
                <button class="send-button" type="button" id="sendButton" onclick="sendMessage()">
                    ➤
                </button>
                <script>
                    async function sendMessage() {
                        const messageInput = document.getElementById('messageInput');
                        const messageText = messageInput.value.trim();
                        if (!messageText) return; // не отправляем пустые
                        
                        messageInput.value = '';

                        const message = {
                            chat_id: <?php echo json_encode($chat_id); ?>,
                            sender_id: <?php echo json_encode($current_user_id); ?>,
                            message_text: messageText,
                            sent_at: new Date().toISOString(),
                            is_read: 0
                        };
                        console.log('Отправляем сообщение:', message);
                        
                        const result = await sendForm(message);
                        console.log('Ответ сервера:', result);
                    }
                    
                    async function sendForm(message) { 
                        const response = await fetch('./send_message.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json'},
                            body: JSON.stringify(message)
                        });
                        
                        const result = await response.json(); // добавил получение ответа
                        return result;
                    }
                </script>
            </div>
        </div>
    </section>
</body>
<script src="script.js"></script>
<script src="messages.js"></script>

</html>
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
            <a href="ad.php?id=<?php echo htmlspecialchars($id); ?>" class="chat-info">
                <img src="<?php echo htmlspecialchars($img);?>" alt="avatar" class="chat-avatar">
                <div class="chat-details">
                    <h2 class="chat-name"><?php echo htmlspecialchars($seller_name);?></h2>
                    <p class="chat-product">Объявление: <?php echo htmlspecialchars($title);?></p>
                </div>
            </a>
            <a href="#" onclick="history.back(); return false;" class="back-button">← Назад</a>
        </div>












        <!-- Область сообщений -->
        <div class="messages-container" id="messagesContainer">
        

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
            </div>
        </div>
    </section>





    
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

<script>
    // Функция для прокрутки вниз
    function scrollToBottom() {
        var container = document.getElementById('messagesContainer');
        container.scrollTop = container.scrollHeight;
    }

    // Функция загрузки сообщений
    function loadMessages() {
        fetch(`get_messages.php?chat_id=<?php echo $chat_id; ?>&user_id=<?php echo $current_user_id; ?>`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('messagesContainer').innerHTML = html;
            });
    }
    
    // Загружаем сообщения и прокручиваем вниз при загрузке страницы
    loadMessages();
    
    // Прокручиваем вниз после загрузки страницы
    setTimeout(scrollToBottom, 100); // Небольшая задержка для полной загрузки
    
    // Каждую секунду обновляем сообщения, НО БЕЗ ПРОКРУТКИ
    setInterval(loadMessages, 1000);
</script>

<script>
    async function sendMessage() {
        const messageInput = document.getElementById('messageInput');
        const messageText = messageInput.value.trim();
        if (!messageText) return;
        
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
        
        // Прокручиваем вниз после отправки сообщения
        setTimeout(scrollToBottom, 800);
    }
</script>
    <script>
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // предотвращает возможную отправку формы
            sendMessage();
        }
    });
    </script>
    <script>
        // Каждую секунду отправляем user_id и получаем ответ
        setInterval(async () => {
            const response = await fetch(`notification.php?user_id=<?php echo $current_user_id; ?>`);
            const data = await response.json();

            const button = document.querySelector('.header .header__right .chats__button');
            if (data.length > 0) {
                button.setAttribute('data-count', data.length);
                button.classList.remove('hide-badge');
            } else {
                button.classList.add('hide-badge');
            }
            
            // ОЧИЩАЕМ ul перед добавлением новых элементов
            const ul = document.querySelector('.header .header__right .chats__window .chats ul');
            ul.innerHTML = ''; // ← очистка
            
            data.forEach(message => {
                
                console.log(message);
                let link = document.createElement("a");
                link.target = "_self";
                link.style.textDecoration = "none";
                link.style.color = "inherit";
                link.style.display = "block";
                link.style.height = "100%";
                link.style.width = "100%";
                
                if (message.buyer_id == <?php echo $current_user_id; ?>) {
                    console.log(message['ad_id'], 'ns - покупатель');
                    link.href = `get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                } else {
                    console.log(message['ad_id'], 'ns - продавец');
                    link.href = `get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                }
                ul.append(link);
            });
        }, 1000);
        </script>
</body>
<script src="script.js"></script>


</html>
<?php
require_once 'session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя

$dbc = mysqli_connect('localhost', 'root', '', 'market');

// Экранируем для безопасности
$current_user_id = mysqli_real_escape_string($dbc, $current_user_id);

$query = "SELECT * from chats where buyer_id = $current_user_id or seller_id = $current_user_id";
$result = mysqli_query($dbc, $query);

$chats = [];

if ($result && mysqli_num_rows($result) > 0) {
    while($chat = mysqli_fetch_assoc($result)) {
        // Для каждого чата получаем последнее сообщение
        $chat_id = $chat['id'];
        
        $query_message = "SELECT * from messages where chat_id = $chat_id order by sent_at desc limit 1";
        $result_message = mysqli_query($dbc, $query_message);
        
        if ($result_message && mysqli_num_rows($result_message) > 0) {
            $chat['last_message'] = mysqli_fetch_assoc($result_message);
        } else {
            $chat['last_message'] = null; // нет сообщений в чате
        }
        
        $chats[] = $chat;
    }
}


// Теперь в $chats каждый чат содержит поле last_message с последним сообщением
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEFUchota</title>
    <link rel="stylesheet" href="ssstyle.css">
</head>
<body>
    <header class="header">
        <div class="header__left">
            <button class="more__button" id="more__button"></button>
            <p class="had__name">FEFUchota</p>
        </div>

        <div class="header__right">
            <?php if ($username): ?>
                <button class="chats__button"></button>
            <?php endif; ?>
            <section class="chats__window">
                <div class="chats__info">
                    <p>Чаты</p>
                </div>
                <div class="chats">
                    <ul>
                        <li class="#">загрузка</li>
                    </ul>
                </div>
            </section>
            
            <!-- Имя пользователя -->
            <p class="your__login">
                <?php 
                if ($username) {
                    echo htmlspecialchars($username);
                } else {
                    echo 'Гость';
                }
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
                    <li><a href="../chats/index.php"> <p>все чаты</p> <img src="../img/car.svg"/> </a></li>
                    <div class="commercial">рекламо</div>
                </ul>
            </div>
        </div>
    </section>

    <section class="chatss">
        <div class="all__chats">

                <h2 class = 'load'> загрузка...</h2>

        </div>
    </section>







    <footer class = "footer">
        <p>
            комит 1
            рекламо
            мама лама
        </p>
    </footer>
    <script>
            // Создаем объект с текстами сообщений для быстрого доступа по ID чата
        

        // Каждую секунду отправляем user_id и получаем ответ
        setInterval(async () => {

            const response = await fetch(`../market/notification.php?user_id=<?php echo $current_user_id; ?>`);
            const data = await response.json(); // в data теперь массив сообщений для текущего пользователя

            const button = document.querySelector('.header .header__right .chats__button');
            if (data.length > 0) {
                button.setAttribute('data-count', data.length);
                button.classList.remove('hide-badge');
            } else {
                button.classList.add('hide-badge');
            }
            
            // ОЧИЩАЕМ ul перед добавлением новых элементов
            const ul = document.querySelector('.header .header__right .chats__window .chats ul');
            const all__chats = document.querySelector('body .chatss .all__chats');
            ul.innerHTML = ''; // ← очистка
            all__chats.innerHTML = ''; // ← очистка
            data.forEach(message => {

                let chat__block = document.createElement("a");
                chat__block.style.display = "flex";
                chat__block.className = 'chat__block';
                chat__block.target = "_self";
                chat__block.style.textDecoration = "none";
                chat__block.style.color = "inherit";
                chat__block.style.display = "block";
                chat__block.style.height = "100%";
                chat__block.style.width = "100%";

                let chat__avatar = document.createElement("img");
                chat__avatar.src = '../img/shopping-cart.svg'; 
                chat__avatar.className = 'chat__avatar';
                chat__block.style.display = "flex";
                let chat__inf = document.createElement("div");
                chat__inf.className = 'chat__inf';

                let companion = document.createElement("h2");
                companion.className = 'companion';
                companion.textContent = `чат обявления: ${message['ad_id']}`;
                chat__block.style.display = "flex";
                let last__message = document.createElement("p");
                last__message.className = 'last__message';
                if (message.last_message_text.length > 20) {
                    last__message.textContent = message.last_message_text.substring(0, 100) + '...';
                } else {
                    last__message.textContent = message.last_message_text || 'Нет сообщений';
                }
                last__message.style.display = "flex";

            // Добавляем класс, если сообщение непрочитано и отправлено не текущим пользователем
                if (message.last_message_is_read == 0 && message.last_message_sender_id != <?php echo $current_user_id; ?>) {
                    chat__block.classList.add('you__unread'); // Добавишь стиль в CSS
                    chat__block.style.backgroundColor = 'red';

                } if( message.last_message_is_read == 0 && message.last_message_sender_id == <?php echo $current_user_id; ?>){
                    chat__block.classList.add('he__unread'); // Добавишь стиль в CSS
                }

                chat__inf.append(companion, last__message);
                chat__block.append(chat__avatar,chat__inf);

                

                
                let link = document.createElement("a");
                link.target = "_self";
                link.style.textDecoration = "none";
                link.style.color = "inherit";
                link.style.display = "block";
                link.style.height = "100%";
                link.style.width = "100%";

                if (message.buyer_id == <?php echo $current_user_id; ?>) {
                    link.href = `../market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                    chat__block.href = `../market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    

                } else {
                    link.href = `../market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    chat__block.href = `../market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                }
                all__chats.append(chat__block);
                ul.append(link);
            });


        
        }, 1000);
        console.log( <?php echo json_encode($chats); ?> );
    </script>
    
</body>
<script src="./script.js"></script>
</html>
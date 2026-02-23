<?php
require_once 'session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEFUchota</title>
    <link rel="stylesheet" href="sstyle.css">
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
                <a href="Login/logout_page.php" class="logout__button">Выйти</a>
            <?php else: ?>
                <!-- Если пользователь НЕ вошёл ($username пустой) -->
                <a href="Login/index.php" class="login__button"></a>
            <?php endif; ?>
        </div>
    </header>

    <section class="menu">
        <div id="sidebar">
            <div class="nav">
                <ul>
                    <li><a href="index.php"> <p>главная</p> </a></li>
                    <li><a href="market/index.php"> <p>рыночек</p> <img src="img/shopping-cart.svg"/> </a></li>
                    <li><a href= "#"> <p>потеряшки</p> <img src="img/hand-paper.svg"/> </a></li>
                    <li><a href="#"> <p>спорт</p> <img src="img/ball.svg"/> </a></li>
                    <li><a href="#"> <p>соседи</p> <img src="img/house.svg"/> </a></li>
                    <li><a href="#">  <p>доставка</p> <img src="img/basket-shopping-simple.svg"/> </a></li>
                    <li><a href="#"> <p>попутчики</p> <img src="img/car.svg"/> </a></li>
                    <div class="commercial">рекламо</div>
                </ul>
            </div>
        </div>
    </section>


    <section>
        <div class="blocks">
            <div class="blocks__up">
                <ul>
                    <li><a href="Market/index.php"> <img src="img/shopping-cart.svg"/> <p>рыночек</p></a></li>
                    <li><a href="#"> <img src="img/hand-paper.svg"/> <p>потеряшки</p></a></li>
                    <li><a href="#"> <img src="img/ball.svg"/> <p>спорт</p></a></li>
                </ul>
            </div>

            <div class="blocks__down">
                <ul>
                    <li><a href="#"> <img src="img/house.svg"/> <p>соседи</p></a></li>
                    <li><a href="#"> <img src="img/basket-shopping-simple.svg"/> <p>доставка</p></a></li>
                    <li><a href="#"> <img src="img/car.svg"/> <p>попутчики</p></a></li>
                </ul>
            </div>
        </div>
    </section>

    <footer>
        <p>
            комит 1
            рекламо
            мама лама
        </p>
    </footer>
    <script>
        // Каждую секунду отправляем user_id и получаем ответ
        setInterval(async () => {
            const response = await fetch(`market/notification.php?user_id=<?php echo $current_user_id; ?>`);
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
                    link.href = `market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                } else {
                    console.log(message['ad_id'], 'ns - продавец');
                    link.href = `market/get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                    link.textContent = `чат обяв.: ${message['ad_id']}`;
                }
                ul.append(link);
            });
        }, 1000);
        </script>
    
</body>
<script src="./script.js"></script>
</html>
<?php
// ПЕРВАЯ строка в файле
require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя


// 1. Получаем ID из URL
$id = $_GET['id'] ?? 0; // id объявления


if (!$id || !is_numeric($id)) {
    die("Некорректный ID объявления.");
}

// 2. Подключаемся к базе данных
$dbc = mysqli_connect ('localhost', 'root', '', 'market');

$query = "SELECT * FROM market WHERE id = $id";
$result = mysqli_query($dbc, $query);
$ad = mysqli_fetch_assoc($result);// объявление

$seller_id = $ad['user_id']; // id продавца

if (!$ad) {
    die("Объявление не найдено.");
}






////////////////////////////////////////////////////////////////







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($ad['name']); ?> | FEFUchota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="header__left">
            <button class="more__button" id="more__button"></button>
            <p class="had__name">FEFUchota</p>
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
                    <div class="commercial">рекламо</div>
                </ul>
            </div>
        </div>
    </section>
    <!-- Основное содержание -->
    <div class="ad-detail">
        <a href="javascript:history.back()" class="back-button">← Назад</a>
        
        <img src="<?php echo htmlspecialchars($ad['img']); ?>" alt="<?php echo htmlspecialchars($ad['name']); ?>">
        
        <h1> название: <?php echo htmlspecialchars($ad['name']); ?></h1>
        
        <div class="price">Цена: <?php echo htmlspecialchars($ad['price']); ?>р</div>
        
        <div class="description">
            <strong>Описание:</strong><br>
            <?php echo nl2br(htmlspecialchars($ad['description'])); ?>
        </div>
        
        <div class="meta">
            <p><strong>Местоположение:</strong> <?php echo htmlspecialchars($ad['tags']); ?></p>
            <p><strong>Период:</strong> <?php echo htmlspecialchars($ad['period']); ?></p>
            <p><strong>Доставка:</strong> <?php echo htmlspecialchars($ad['delivery']); ?></p>
            <p><strong>Дата публикации:</strong> <?php echo date('d.m.Y', strtotime($ad['date'])); ?></p>
        </div>

        <a href="get_or_create_chat.php?ad_id=<?php echo urlencode($ad['id']); ?>" class="cand">написать</a>
    </div>
</body>
<script src="script.js"></script>
</html>

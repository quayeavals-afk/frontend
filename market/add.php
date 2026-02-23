<?php
require_once '../session_start.php';
$username = getUsername();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEFUchota</title>
    <link rel="stylesheet" href="1style.css">
    <link rel="stylesheet" href="style2.css">
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

    <section>
         <form action="add_ad.php" method="POST" class="add__window" enctype="multipart/form-data">
            <div class="form-inner">
                <h1>Contact us</h1>
                <input type="text" class="name" maxlength="17" placeholder="name" name ="name" required>
                <textarea class = 'description'placeholder="description..." rows="3" maxlength = "200" name ="description"required></textarea>
                <input type="file" class="image" name="image" accept="image/*" required>
                <div class="location box">
                    <h2>где</h2>
                    <input type="radio" class="location" value="корпус 6" name = "tags"required>корпус 6 
                    <input type="radio" class="location" value="корпус 7" name = "tags"required>корпус 7
                    <input type="radio" class="location" value="корпус 8" name = "tags"required>корпус 8
                    <input type="radio" class="location" value="корпус 9" name = "tags"required>корпус 9
                    <input type="radio" class="location" value="корпус 10" name = "tags"required>корпус 10
                    <input type="radio" class="location" value="корпус 11" name = "tags"required>корпус 11
                    <input type="radio" class="location" value="корпус 1.8" name = "tags"required>корпус 1.8
                    <input type="radio" class="location" value="корпус 1.10" name = "tags"required>корпус 1.10
                    <input type="radio" class="location" value="корпус 2.1–2.7" name = "tags"required>корпус 2.1–2.7
                    <input type="radio" class="location" value="город" name = "tags"required>город
                </div>
                <div class="period__box box">
                    <h2>износ</h2>
                    <input type="radio" required name="period" value=">1 месяца">&lt;1 месяца
                    <input type="radio" required name="period" value="1-6 месяцев">1-6 месяцев
                    <input type="radio" required name="period" value="6-12 месяцев">6-12 месяцев
                    <input type="radio" required name="period" value=">1 года">&gt1 года
                </div>
                    
                <div class="delivery__box box">
                    <h2>доставка</h2>
                    <input type="radio" required name="delivery" value="самовывоз">самовывоз
                    <input type="radio" required name="delivery" value="только по кампусу">по кампусу
                    <input type="radio" required name="delivery" value="только по городу">по городу
                    <input type="radio" required name="delivery" value="везде">везде
                </div>
                    <input type="text" class="price" placeholder="price" maxlength = "6" name ="price" required>
                <button type="submit" class ="add1">add</button>
            </div>
        </form>
    </section>
</body>

<script src="aadd.js"></script>
</html>
<?php
// ПЕРВАЯ строка в файле
require_once '../session_start.php';
$username = getUsername();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="header__left">
            <button class="more__button" id="more__button"></button>
            <p class="had__name">FEFUchota</p>
        </div>

        <div class="header__right">
            
            
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
                    <li><a href="../market/index.php"> <p>рыночек</p> <img src="../img/shopping-cart.svg"/> </a></li>
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


    
    <div class="container">
        
        










        <form id="registerationForm">
            <h2 class = "h2">Регистрация</h2>
            <div class="form-group">
                <label for="log-username">Имя пользователя:</label>
                <input class = "input" type="text" id="log-username" name="username" required>
                <div class="error" id="usernameError"></div>
            </div>
            
            <div class="form-group">
                <label for="log-email">Email:</label>
                <input class = "input" type="email" id="log-email" name="email" required>
                <div class="error" id="emailError"></div>
            </div>
            
            <div class="form-group">
                <label for="log-password">Пароль:</label>
                <input class = "input" type="password" id="log-password" name="password" required>
                <div class="error" id="passwordError"></div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Подтвердите пароль:</label>
                <input class = "input" type="password" id="confirmPassword" name="confirmPassword" required>
                <div class="error" id="confirmPasswordError"></div>
            </div>
            
            <button class="submit button" type="submit">Зарегистрироваться</button>
            
            <div class="login-link">
                <p>Уже есть аккаунт? <button type="button" class="variant button">войти</button></p>
            </div>
        </form>













        <form  method="POST" action="login.php" id="loginForm">
            <h2 class = "h2">Вход</h2>
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input class = "input" type="text" id="username" name="username" required>
                <div class="error" id="usernameError"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input class = "input" type="password" id="password" name="password" required>
                <div class="error" id="passwordError"></div>
            </div>
            
            <button type="submit" class="submit button">войти</button>
            
            <div class="login-link">
                <p>Уже есть аккаунт? <button type="button" class="variant button">Зарегистрироваться</button></p>
            </div>
        </form>









    </div>
    <script src="./script.js"></script>
</body>
</html>
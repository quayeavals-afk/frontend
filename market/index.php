<?php
// ПЕРВАЯ строка в файле
require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEFUchota </title>
    <link rel="stylesheet" href="1style.css">
</head>
<body>
    <header class="header">
        <div class="header__left">
            <button class="more__button" id="more__button"></button>
            <p class="had__name">FEFUchota | <?php echo $current_user_id; ?></p>
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


    <section class="table">
        <div class="table__header">
            <div class="search_sistem">
                <button class="button__tags"></button>

                <div class="tags__box">
                    <h2 class="tags__name">Теги</h2>
                    <button class="reset">reset</button>
                    
                    <button class="location__button">где</button>
                    <div class="location__box box">
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 6" name="tags">
                            <span class="location-text">корпус 6</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 7" name="tags">
                            <span class="location-text">корпус 7</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 8" name="tags">
                            <span class="location-text">корпус 8</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 9" name="tags">
                            <span class="location-text">корпус 9</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 10" name="tags">
                            <span class="location-text">корпус 10</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 11" name="tags">
                            <span class="location-text">корпус 11</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 1.8" name="tags">
                            <span class="location-text">корпус 1.8</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 1.10" name="tags">
                            <span class="location-text">корпус 1.10</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="корпус 2.1–2.7" name="tags">
                            <span class="location-text">корпус 2.1–2.7</span>
                        </label>
                        <label class="location-label">
                            <input type="checkbox" class="location" value="город" name="tags">
                            <span class="location-text">город</span>
                        </label>
                    </div>
                    
                    <button class="period__button">срок использования</button>
                    <div class="period__box box">
                        <label class="period-label">
                            <input type="checkbox" name="period" value=">1 месяца">
                            <span class="period-text">&lt;1 месяца</span>
                        </label>
                        <label class="period-label">
                            <input type="checkbox" name="period" value="1-6 месяцев">
                            <span class="period-text">1-6 месяцев</span>
                        </label>
                        <label class="period-label">
                            <input type="checkbox" name="period" value="6-12 месяцев">
                            <span class="period-text">6-12 месяцев</span>
                        </label>
                        <label class="period-label">
                            <input type="checkbox" name="period" value=">1 года">
                            <span class="period-text">&gt;1 года</span>
                        </label>
                    </div>
                    
                    <button class="delivery__button">доставка</button>
                    <div class="delivery__box box">
                        <label class="delivery-label">
                            <input type="checkbox" name="delivery" value="самовывоз">
                            <span class="delivery-text">самовывоз</span>
                        </label>
                        <label class="delivery-label">
                            <input type="checkbox" name="delivery" value="только по кампусу">
                            <span class="delivery-text">по кампусу</span>
                        </label>
                        <label class="delivery-label">
                            <input type="checkbox" name="delivery" value="только по городу">
                            <span class="delivery-text">по городу</span>
                        </label>
                        <label class="delivery-label">
                            <input type="checkbox" name="delivery" value="везде">
                            <span class="delivery-text">везде</span>
                        </label>
                    </div>
                    <button class = "apply"> применить</button>
                </div>

                <input type="text" id="input__field__text" name="input__field__text" size="40" placeholder="ключевые слова"/>

                <button class="button__sort"></button>
                <div class="sort__box" >
                    <h2 class="sort__name"> сортировка</h2>
                    <button class="sort-new">сначала новые</button>
                    <button class="sort-old">сначала старые</button>
                    <button class="sort-cheap">дешевле</button>
                    <button class="sort-expensive">дороже</button>
                </div>

            </div>
            <div class="add">
                <?php if ($username): ?>
                <!-- Если пользователь вошёл ($username не пустой) -->
                <a href="add.php" class="add__window" 
                    style="color: red; font-size: 60px; padding: 10px 20px; margin-top: -10px; text-align: center; background-color: #00ff88;">
                    add</a>
            <?php else: ?>
                <!-- Если пользователь НЕ вошёл ($username пустой) -->
                <p class = "mama" style="color: red; font-size: 36px; text-align: center;">войдите, чтоб добавить объявление</p>
            <?php endif; ?>


                
            </div>
        </div>
        <div class="store"></div>
    </section>

    <footer>
        <p>рекламо</p>
    </footer>
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
        
        const ul = document.querySelector('.header .header__right .chats__window .chats ul');
        ul.innerHTML = ''; // ← очистка
        
        data.forEach(message => {
            let link = document.createElement("a");
            link.target = "_self";
            link.style.textDecoration = "none";
            link.style.color = "inherit";
            link.style.display = "block";
            link.style.height = "100%";
            link.style.width = "100%";
            
            if (message.buyer_id == <?php echo $current_user_id; ?>) {
                link.href = `get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                link.textContent = `чат обяв.: ${message['ad_id']}`;
            } else {
                link.href = `get_or_create_chat.php?ad_id=${message['ad_id']}&chat_id=${message['id']}`;
                link.textContent = `чат обяв.: ${message['ad_id']}`;
            }
            ul.append(link);
        });
    }, 1000);
    </script>
</body>
<script src="script.js"></script>
<script src="add.js"></script>

</html>
<?php
// отправка данных из формы на сервер и сохранение в базе данных

require_once '../session_start.php';
$username = getUsername();
$current_user_id = getUserId(); // id покупателя

// 1. Подключаемся к базе
$dbc = mysqli_connect('localhost', 'root', '', 'market');

// 2. Проверяем, загружен ли файл
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    die("Ошибка: файл не загружен");
    header('Location: add.php');
    exit();
}

// 3. Данные из формы
$name = $_POST['name'];
$description = $_POST['description'];
$tags = $_POST['tags'];
$period = $_POST['period'];
$delivery = $_POST['delivery'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');

// 4. Проверяем, действительно ли это изображение
$check = getimagesize($_FILES['image']['tmp_name']);    
if ($check === false) {
    die("Ошибка: файл не является изображением");
    header('Location: add.php');
    exit();
}

// 5. Проверка размера (не больше 2MB)
if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
    die("Ошибка: файл слишком большой (макс. 2MB)");
    header('Location: add.php');
    exit();
}

// 6. Проверяем расширение
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    die("Ошибка: допустимы только JPG, PNG, GIF");
    header('Location: add.php');
    exit();
}

// 7. Генерируем уникальное имя файла
$new_filename = uniqid() . '.' . $ext;

// 8. Куда сохраняем (путь относительно корня сайта)
$upload_dir = '../uploads/';
$destination = $upload_dir . $new_filename;

// 9. Сохранение файла на сервер
if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    die("Ошибка при сохранении файла на сервер");
}

// 10. Экранирование пути к файлу для БД
$image_path = mysqli_real_escape_string($dbc, $destination);

// 11. Экранирование всех данных для безопасности
$username = mysqli_real_escape_string($dbc, $username);
$current_user_id = mysqli_real_escape_string($dbc, $current_user_id);
$name = mysqli_real_escape_string($dbc, $name);
$description = mysqli_real_escape_string($dbc, $description);
$tags = mysqli_real_escape_string($dbc, $tags);
$period = mysqli_real_escape_string($dbc, $period);
$delivery = mysqli_real_escape_string($dbc, $delivery);
$price = mysqli_real_escape_string($dbc, $price);

// 12. Вставляем данные в БД (id убран - он auto_increment)
$query = "INSERT INTO market (user_id, username, img, name, description, tags, period, delivery, price, date) 
          VALUES ('$current_user_id', '$username', '$image_path', '$name', '$description', '$tags', '$period', '$delivery', '$price', '$date')";

$result = mysqli_query($dbc, $query);

if ($result) {
    header('Location: index.php');
    exit();
} else {
    echo "❌ Ошибка БД: " . mysqli_error($dbc);
}

mysqli_close($dbc);
?>
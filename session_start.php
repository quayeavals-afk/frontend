<?php
// Всегда первой строкой файла
session_start();

// Проверяем, вошёл ли пользователь
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Получаем имя пользователя
function getUsername() {
    return $_SESSION['username'] ?? null; // ?? = если нет, то null
}

// Получаем ID пользователя
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>
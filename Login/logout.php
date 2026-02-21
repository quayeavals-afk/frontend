<?php
// Login/logout.php

// 1. Начинаем сессию
session_start();

// 2. Очищаем все данные сессии
session_unset();
session_destroy();

// 3. Перенаправляем на главную
header('Location: index.php');
exit;
?>
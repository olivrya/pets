<?php

function online()
{
    // Проверка, вошел ли пользователь
    if (isset($_SESSION['user_id'])) {
        // Пользователь вошел, обновляем время последней активности
        $_SESSION['last_activity'] = time();
        return true; // Пользователь авторизован
    } else {
        return false; // Пользователь не авторизован
    }
}
?>
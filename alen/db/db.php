<?php 
// Устанавливаем соединение с базой данных MySQL
$connect = mysqli_connect("localhost", "root", "", "funeral");

// Проверяем успешность установления соединения
if(!$connect) {
    // Если соединение не установлено, выводим сообщение об ошибке
    echo "err mysqli";
}

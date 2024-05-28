<?php
require_once("../db/db.php"); // Подключаем файл с настройками базы данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем ID заявки из формы
    $request_id = $_POST['id'];
}
?>
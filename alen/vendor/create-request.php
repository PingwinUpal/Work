<?php 

session_start(); // Начинаем сессию для работы с сессионными переменными

// Проверяем, авторизован ли пользователь
if(empty($_COOKIE['id_user'])) {
    // Если нет, сохраняем сообщение об ошибке в сессии и перенаправляем на страницу авторизации
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
    exit(); // Прекращаем выполнение скрипта после редиректа
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

// Получаем данные из POST-запроса
$id_client = $_POST['id_client'];
$id_funeral = $_POST['id_funeral'];

// Инициализируем массив для хранения идентификаторов услуг
$services = [];

// Перебираем все POST-параметры
foreach ($_POST as $key => $value) {
    // Проверяем, начинается ли имя параметра с 'id_service_'
    if (strpos($key, 'id_service_') === 0) {
        // Если да, добавляем значение в массив услуг
        $services[] = $value;
    }
}

// Преобразуем массив идентификаторов услуг в строку, разделенную запятыми
$services_string = implode(',', $services);

// Выполняем SQL-запрос для вставки данных в таблицу requests
mysqli_query($connect, "INSERT INTO `requests` 
                        (`id_client`, `id_funeral`, `services`)
                        VALUES
                        ('$id_client', '$id_funeral', '$services_string')
");

// Перенаправляем пользователя на главную страницу после успешного выполнения запроса
header("Location: ../index.php");
exit(); // Прекращаем выполнение скрипта после редиректа

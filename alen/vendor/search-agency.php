<?php
session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
    exit(); // Прекращаем выполнение скрипта после редиректа
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

// Проверяем, был ли отправлен POST-запрос с параметром 'search'
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // Подготавливаем SQL-запрос с использованием подготовленных выражений для предотвращения SQL-инъекций
    $stmt = $connect->prepare("SELECT `id`, `name_agency` FROM `funeral_agencies` WHERE `name_agency` LIKE ?");
    $searchParam = "%$search%";
    $stmt->bind_param("s", $searchParam); // Связываем параметр search с запросом
    $stmt->execute(); // Выполняем запрос
    $result = $stmt->get_result(); // Получаем результат запроса

    $agencies = array();

    // Извлекаем результаты запроса и добавляем их в массив
    while ($row = $result->fetch_assoc()) {
        $agencies[] = $row;
    }

    // Возвращаем результаты в формате JSON
    echo json_encode($agencies);

    // Закрываем подготовленный запрос и соединение с базой данных
    $stmt->close();
    $connect->close();
} else {
    echo json_encode(array("error" => "Invalid request"));
}

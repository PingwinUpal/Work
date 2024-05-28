<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

$select_funerals = mysqli_query($connect, "SELECT `id`, `name_agency` FROM `funeral_agencies`");
$select_funerals = mysqli_fetch_all($select_funerals);

$id_client = $_COOKIE['id_user'];

$select_requests = mysqli_query($connect,"SELECT * FROM `requests` WHERE `id_client` = '$id_client'");
$select_requests = mysqli_fetch_all($select_requests);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>
<body>
    <a href="./logout.php">Выйти</a>
    <br><br>

    <div class="search">
        <input type="search" name="search_funeral" id="search_funeral" placeholder="Поиск категорий тортов">
        <input type="button" id="search_button" value="Искать">
        <div id="results"></div>
    </div>

    <div class="list_funerals">
        <h2>Список категорий</h2>
        <?php foreach($select_funerals as $funeral) { ?>
            <ul>
                <li><a href="./funeral_agency.php?id=<?= $funeral[0] ?>"><?= $funeral[1] ?></a></li>
            </ul>
        <?php } ?>
    </div>

    <div class="list_requests">
        <h2>Мои заказы</h2>
        <?php foreach($select_requests as $request) { 
            $id_agency = $request[2];
            $select_agency = mysqli_query($connect, "SELECT `name_agency`, `services` FROM `funeral_agencies` WHERE `id`='$id_agency'");
            $select_agency = mysqli_fetch_assoc($select_agency);

            $ids = explode(',', $request[3]);

            $conditions = array_map(function($id) {
                return "JSON_CONTAINS(JSON_EXTRACT(`services`, '$.additional_services[*].id'), '$id')";
            }, $ids);

            $whereClause = implode(' OR ', $conditions);

            $query = "SELECT `services` FROM `funeral_agencies` WHERE `id`='$id_agency' AND ($whereClause)";

            $result = mysqli_query($connect, $query);

            $selected_services = [];

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $services = json_decode($row['services'], true);
                    foreach ($services['additional_services'] as $service) {
                        if (in_array($service['id'], $ids)) {
                            $selected_services[] = $service;
                        }
                    }
                }
            } else {
                echo "Ошибка выполнения запроса: " . mysqli_error($connect);
            }

            ?>
            <ul>
                <li>
                    <span>Выбранная категории - <?= htmlspecialchars($select_agency['name_agency']) ?></span>
                    <br>
                    <span>
                        Заказ:
                        <ul>
                            <?php foreach ($selected_services as $service): ?>
                                <li><?= htmlspecialchars($service['name']) ?> - <?= htmlspecialchars($service['price']) ?> руб.</li>
                            <?php endforeach; ?>
                        </ul>
                    </span>
                </li>
            </ul>
            <hr>
        <?php } ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#search_button').click(function() {
                var searchQuery = $('#search_funeral').val(); // Получаем значение из поля ввода

                $.ajax({
                    url: './vendor/search-agency.php',
                    type: 'POST',
                    data: {
                        search: searchQuery // Передаем значение на сервер
                    },
                    success: function(response) {
                        var agencies = JSON.parse(response);
                        var html = '';

                        console.log("asd");

                        // Проверяем, есть ли результаты поиска
                        if (agencies.length > 0) {
                            // Создаем список ul
                            html += '<ul>';
                            
                            // Перебираем массив агентств и добавляем их в HTML
                            for (var i = 0; i < agencies.length; i++) {
                                html += '<li><a href="./funeral_agency.php?id=' + agencies[i].id + '">' + agencies[i].name_agency + '</a></li>';
                            }
                            
                            // Закрываем список ul
                            html += '</ul>';
                        } else {
                            // Если нет результатов поиска, выводим сообщение об этом
                            html += '<p>Результатов нет.</p>';
                        }

                        // Очищаем содержимое контейнера results перед добавлением новых данных
                        $('#results').empty();

                        // Выводим результаты поиска на страницу
                        $('#results').html(html);
                    },
                    error: function() {
                        alert('Ошибка при выполнении AJAX запроса');
                    }
                });
            });
        });
    </script>
</body>
</html>
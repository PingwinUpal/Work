<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

$id_funeral_agency = $_GET['id'];

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

$select_funeral = mysqli_query($connect, "SELECT `name_agency`, `services` FROM `funeral_agencies` WHERE `id`='$id_funeral_agency'");
$select_funeral = mysqli_fetch_assoc($select_funeral);

$services = json_decode($select_funeral['services'], true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $select_funeral['name_agency'] ?></title>
</head>
<body>
    <a href="./index.php">Назад</a>
    <h2>Услуги агентства - <?= $select_funeral['name_agency'] ?></h2>

    <div class="services">
        <?php foreach($services as $service) { 
            foreach($service as $s) { ?>
                <ul>
                    <li>
                        <span><?= $s['name'] ?></span> - <span><?= $s['price'] ?>руб.</span>
                    </li>
                </ul>
            <?php } ?>
        <?php } ?>
    </div>

    <div class="create-request">
        <h2>Создать заявку</h2>
        <form action="./vendor/create-request.php" method="post">
            <input type="hidden" name="id_client" value="<?= $_COOKIE['id_user'] ?>">
            <input type="hidden" name="id_funeral" value="<?= $id_funeral_agency ?>">
            <?php foreach($services as $service) { 
                foreach($service as $s) { ?>
                    <ul>
                        <li>
                            <input type="checkbox" name="id_service_<?= $s['id'] ?>" value="<?= $s['id'] ?>">
                            <span><?= $s['name'] ?></span>
                        </li>
                    </ul>
                <?php } ?>
            <?php } ?>
            <input type="submit" value="Создать">
        </form>
    </div>
    <div class="delete-request">
        <h2>удалить заявку</h2>
        <form action="delete_request.php" method="post">
            <label for="id">ID заявки:</label>
            <input type="text" id="id" name="id">
            <input type="submit" value="Удалить">
    </form> 
    </div>
</body>
</html>
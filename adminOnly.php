<?php
//Запуск сессий;
session_start();

//если пользователь не авторизован
if (!(isset($_SESSION['Name']))) {
    //идем на страницу авторизации
    header("Location: login.php");
    exit;
};

// если пользователь не админ
if (!(isset($_SESSION['isAdmin']))) {
    //идем на страницу пользователя
    header("Location: /"); // TODO можно например сделать страницу пользователя или хз что
    exit;
};


require_once("./template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" type="text/css" href="../style/adminOnly_Style.css" />';

// Импорт html
$html = getCommonTemplate(1, $add_to_head);
$content = file_get_contents("./html/adminOnly.html");

// Подставляем
$html = str_replace('{content}', $content, $html);

$html = deleteAllPlaceholdersLeft($html);
echo $html;

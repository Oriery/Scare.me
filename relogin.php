<?php

require_once("./template_utils.php");

// Импорт html
$html = file_get_contents("html/login.html");

// Подставляем
$html = str_replace('{not_correct}', "Неверный логин или пароль", $html);

$html = deleteAllPlaceholdersLeft($html);
echo $html;
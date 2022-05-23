<?php

session_start();

require_once(__DIR__ . "/service/template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" type="text/css" href="../style/lendingStyle.css" />';
$after_body = '<script type="text/javascript" src="scripts/regex_form.js"></script>';

// Импорт html
$html = getCommonTemplate(1, $add_to_head);
$content = file_get_contents("./html/lending.html");

// Подставляем
$html = str_replace('{content}', $content, $html);
$html = str_replace('{after_body}', $after_body, $html);

$html = deleteAllPlaceholdersLeft($html);
echo $html;
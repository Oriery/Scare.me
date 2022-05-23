<?php

require_once(__DIR__ . "/service/adminCheck.php");
require_once(__DIR__ . "/service/template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" type="text/css" href="../style/adminOnly_Style.css" />';

// Импорт html
$html = getCommonTemplate(4, $add_to_head);
$content = file_get_contents("./html/adminOnly.html");

// Подставляем
$html = str_replace('{content}', $content, $html);

$html = deleteAllPlaceholdersLeft($html);
echo $html;

<?php

require_once("./template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" type="text/css" href="../style/lendingStyle.css" />';

// Импорт html
$html = getCommonTemplate(1, $add_to_head);
$content = file_get_contents("./html/lending.html");

// Подставляем
$html = str_replace('{content}', $content, $html);

echo $html;
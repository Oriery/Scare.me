<?php

require_once("./template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" href="../style/helpStyle.css">';

// Импорт html
$html = getCommonTemplate(1, $add_to_head);
$content = file_get_contents("./html/helpContent.html");

// Подставляем
$html = str_replace('{content}', $content, $html);

echo $html;
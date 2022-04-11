<?php

// Для дебага удобно
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

// Импорт html
$main_template = file_get_contents("./html/templ_main.html");
$header = file_get_contents("./html/header.html");
$content = file_get_contents("./html/lending.html");
$footer = file_get_contents("./html/footer.html");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" type="text/css" href="../style/lendingStyle.css" />';

// Подсветка выбранной страницы в меню хедера
$header = preg_replace_callback("{{(selected):(\d)}}", 
    function($m) {
        if ($m[2] == "1") {     
           return $m[1];
        } else {
            return "";
        }
    }, 
    $header);

// просто всё подставляем в темплейт
$main_template= str_replace('{add_to_head}', $add_to_head, $main_template);
$main_template= str_replace('{header}', $header, $main_template);
$main_template= str_replace('{content}', $content, $main_template);
$main_template= str_replace('{footer}', $footer, $main_template);

echo $main_template;
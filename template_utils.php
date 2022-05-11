<?php

// Для дебага удобно
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

// Эта функция оставляет только то слово, которое стоит перед двоеточием и числом, если число совпадает
// Например при 
//      $str="lorem ipsum {selected:1} lorem ipsum {selected:2} " 
//      $whichToLet=1 
// функция возвращает 
//           "lorem ipsum selected lorem ipsum  " 
function letOnlyWithSpecificNumber(string $str, string $word, int $whichToLet) : string {
    preg_match_all("{{($word):(\d)}}", $str, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        if ((int)$m[2] == $whichToLet) {     
            $str = str_replace($m[0], $m[1], $str);
        } else {
            $str = str_replace($m[0], "", $str);
        }
    }

    return $str;
}

// Даёт основной темплейт, в котором есть Хедер(вместе с подстветкой) и Футер
function getCommonTemplate(int $numOfPage, string $add_to_head) : string {
    // Основной импорт
    $html = file_get_contents("./html/templ_main.html");
    $header = file_get_contents("./html/templ_header.html");
    $footer = file_get_contents("./html/footer.html");

    // Подсветка выбранной страницы в меню хедера 
    $header = letOnlyWithSpecificNumber($header, "selected", $numOfPage);

    // Подставляем
    $html = str_replace('{add_to_head}', $add_to_head, $html);
    $html = str_replace('{header}', $header, $html);
    $html = str_replace('{footer}', $footer, $html);

    return $html;
}

function deleteAllPlaceholdersLeft(string $str) : string {
    preg_match_all("{\{.*?\}}", $str, $matches);
    foreach ($matches as $m) {
        $str = str_replace($m, '', $str);
    }
    return $str;
}
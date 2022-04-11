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
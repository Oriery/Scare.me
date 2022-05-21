<?php

require_once("./template_utils.php");

// Импорт html
$html = file_get_contents("html/login.html");

if (isset($_COOKIE["unsuccessfullLogin"])) {
    $html = str_replace('{not_correct}', file_get_contents("html/templ_notCorrect.html"), $html);
}

$html = deleteAllPlaceholdersLeft($html);
echo $html;
<?php

require_once(__DIR__ . "/service/template_utils.php");

// Импорт html
$html = file_get_contents("html/login.html");

if (isset($_COOKIE["errMes"])) {
    $errMesHTML = file_get_contents("html/templ_notCorrect.html");
    $errMesHTML = str_replace("{message}", $_COOKIE["errMes"], $errMesHTML);
    $html = str_replace('{not_correct}', $errMesHTML, $html);
}

$html = deleteAllPlaceholdersLeft($html);
echo $html;
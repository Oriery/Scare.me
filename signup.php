<?php

require_once(__DIR__ . "/service/template_utils.php");

$html = file_get_contents("html/signup.html");

if (isset($_COOKIE["errMes"])) {
    $errMesHTML = file_get_contents("html/templ_notCorrect.html");
    $errMesHTML = str_replace("{message}", $_COOKIE["errMes"], $errMesHTML);
    $html = str_replace('{not_correct}', $errMesHTML, $html);

    $html = str_replace('{login}', $_COOKIE["login"], $html);
    $html = str_replace('{email}', $_COOKIE["email"], $html);
    $html = str_replace('{password1}', $_COOKIE["password1"], $html);
}

$html = deleteAllPlaceholdersLeft($html);
echo $html;
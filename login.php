<?php

require_once("./template_utils.php");

// Импорт html
$html = file_get_contents("html/login.html");

$html = deleteAllPlaceholdersLeft($html);
echo $html;
<?php
require_once("../service/mailService.php");

if (isset($_GET['login']) && isset($_GET['email']) && isset($_GET['key'])) {  
    require_once '../service/DatabaseService.php';
    $dbService = new DatabaseService();

    $email = str_replace(":", "@", $_GET['email']);

    if ($dbService->checkEmailValidationKey($_GET['login'], $email, $_GET['key'])) {
        $dbService->setUserEmail($_GET['login'], $email);
        echo file_get_contents("../html/onSuccEmailVerif.html");
        exit();
    } else {
        echo "Ключ неверный";
        exit();
    }
} else {
    echo "Требуемые данные не переданы";
}

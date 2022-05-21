<?php

if (isset($_POST['question']) && isset($_POST['answer'])) {
    require_once '../service/DatabaseService.php';
    $dbService = new DatabaseService();
    $dbService->createHelpElem($_POST['question'], $_POST['answer']);
    header("Location: /adminOnly.php");
}
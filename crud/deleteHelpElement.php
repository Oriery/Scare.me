<?php
require_once(__DIR__ . "/adminCheck.php");

if (isset($_POST['question'])) {
    require_once '../service/DatabaseService.php';
    $dbService = new DatabaseService();
    $dbService->deleteQuestion($_POST['question']);
    echo $_POST['question'];
}
header("Location: /adminOnly.php");
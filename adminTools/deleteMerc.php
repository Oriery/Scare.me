<?php
require_once("../service/adminCheck.php");

if (isset($_POST['name'])) {
    require_once '../service/DatabaseService.php';
    $dbService = new DatabaseService();
    $dbService->deleteMercenary($_POST['name']);
}
header("Location: /adminOnly.php");
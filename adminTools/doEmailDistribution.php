<?php
require_once("../service/mailService.php");

if (isset($_POST['mail-text']) && isset($_POST['mail-subject'])) {
    $dbService = new DatabaseService();
    $emails = $dbService->getAllEmails();
    foreach ($emails as $e) {
        if ($e["email"]) {
            sendEmail($e["email"], $_POST['mail-subject'], $_POST['mail-text']);
        }
    }
}
header("Location: /adminOnly.php");

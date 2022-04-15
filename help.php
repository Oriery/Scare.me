<?php

require_once("./template_utils.php");
require_once("./service/DatabaseService.php");

$dbService = new DatabaseService();

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" href="../style/helpStyle.css">';

// Импорт html
$html = getCommonTemplate(3, $add_to_head);
$content = file_get_contents("./html/templ_helpContent.html");

$FAQs = getStringOfHtmlsOfFAQs();

// Подставляем
$content = str_replace('{FAQs}', $FAQs, $content);
$html = str_replace('{content}', $content, $html);

echo $html;

function getStringOfHtmlsOfFAQs() : string {
    global $dbService;
    $template = file_get_contents("./html/templ_FAQ.html");
    $htmls = "";
    foreach ($dbService->getHelp() as $item) {
        $html = $template;
        $html = str_replace('{question}', $item["question"], $html);
        $html = str_replace('{answer}', $item["answer"], $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}
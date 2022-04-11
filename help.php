<?php

require_once("./template_utils.php");

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

function getArrayOfFAQ() : array {
    return $arr = [
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
        ["Вопрос", "Ответ"],
    ];
}

function getStringOfHtmlsOfFAQs() : string {
    $template = file_get_contents("./html/templ_FAQ.html");
    $htmls = "";
    foreach (getArrayOfFAQ() as $item) {
        $html = $template;
        $html = str_replace('{question}', $item[0], $html);
        $html = str_replace('{answer}', $item[1], $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}
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
        ["Чем занимается сервис Scare.me?", "Мы предоставляем услуги заказного пугания."],
        ["Как мне заказать пугание?", "Выберите одного из наших специально обученных наёмников, заключите договор с компанией и уже очень скоро наёмник сделает всю работу по лучшим стандартам отрасли."],
        ["Как мне выбрать наёмника?", "Почитайте характеристики и описания наёмников, сравните цены и особенности исполнения.<br>Если у Вас останутся вопросы, Вы всегда можете связаться с нашими консультантами."],
        ["А это легально?", "Нуууу, эээ..."],
        ["Когда происходит оплата?", "В зависимости от наёмника от Вас может потребоваться частичная или полная предоплата."],
        ["Есть ли гарантии?", "У Вас будет гарантия выполнения или крупная страховка от неудачи в зависимости от наёмника."],
        ["Можно ли лично пообщаться с выбранным наёмником?", "В период подготовки у Вас будет анонимная связь с наёмником."],
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
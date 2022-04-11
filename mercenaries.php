<?php

require_once("./template_utils.php");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" href="../style/mercenaryStyle.css">';

// Импорт html
$html = getCommonTemplate(1, $add_to_head);
$content = file_get_contents("./html/templ_mercenaryContent.html");

$mercenaries = getStringOfHtmlsOfMercenaries();

// Подставляем
$content = str_replace('{mercenaries}', $mercenaries, $content);
$html = str_replace('{content}', $content, $html);

echo $html;

function getArrayOfMercenaries() : array {
    return $arr = [
        ["David", 1000, ["аккуратная работа", "гарантии выполнения"], "Опытный наёмник, выполнивший уже много заказов. Тихий и надёжный, он выполнит работу по высоким стандартам. Однако ему может понадобится больше времени на подготовку, нежели его коллегам."],
        ["Max", 300, ["красивое выполнение", "страховка от неудачи"], "Настоящий любитель своего дела..."],
        ["Felix", 600, ["быстрая подготовка", "гарантии выполнения"], "Интересное описание"],
        ["Robert", 400, ["красивое выполнение", "страховка от неудачи"], "Интересное описание"],
        ["John", 150, ["полный хаос", "страховка от неудачи"], "Интересное описание"],
        ["Patrick", 700, ["аккуратная работа", "гарантии выполнения"], "Интересное описание"],
        ["Vault", 850, ["быстрая подготовка", "гарантии выполнения"], "Интересное описание"]
    ];
}

function getStringOfHtmlsOfMercenaries() : string {
    $template = file_get_contents("./html/templ_mercenary.html");
    $htmls = "";
    foreach (getArrayOfMercenaries() as $merc) {
        $html = $template;
        $html = str_replace('{name}', $merc[0], $html);
        $html = str_replace('{price}', $merc[1], $html);
        $html = str_replace('{peculiarities}', getStringOfHtmlsOfPercualities($merc[2]), $html);
        $html = str_replace('{description}', $merc[3], $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}

function getStringOfHtmlsOfPercualities(array $arr) : string {
    $template = " <p><strong>{peculiarity}</strong></p>";
    $htmls = "";
    foreach ($arr as $item) {
        $html = $template;
        $html = str_replace('{peculiarity}', $item, $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}
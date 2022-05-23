<?php

session_start();

require_once(__DIR__ . "/service/template_utils.php");
require_once(__DIR__ . "/service/DatabaseService.php");
$dbService = new DatabaseService();

define("pathToFolderWithImagesOfPerformers", "/media/icons_of_performers/");

// Всё, что должно быть добавлено в head темплейта
// TODO: Скорее всего это плохой вариант
$add_to_head = '<link rel="stylesheet" href="../style/mercenaryStyle.css">';

// Импорт html
$html = getCommonTemplate(2, $add_to_head);
$content = file_get_contents("./html/templ_mercenariesContent.html");

$mercenaries = getStringOfHtmlsOfMercenaries();

// Подставляем
$content = str_replace('{mercenaries}', $mercenaries, $content);
$html = str_replace('{content}', $content, $html);

$html = deleteAllPlaceholdersLeft($html);
echo $html;

function getStringOfHtmlsOfMercenaries(): string
{
    global $dbService;
    $template = file_get_contents("./html/templ_mercenary.html");
    $htmls = "";
    foreach ($dbService->getAllMercinaries() as $merc) {
        $featureArr = $dbService->getFeaturesByMercId($merc["id"]);
        $html = $template;
        $imgPath = pathToFolderWithImagesOfPerformers . $merc["name"] . ".jpg";
        if (!file_exists($imgPath)) {
            $imgPath = pathToFolderWithImagesOfPerformers . "default.jpg";
        }
        $html = str_replace('{img_path}', $imgPath, $html);
        $html = str_replace('{name}', $merc["name"], $html);
        $html = str_replace('{price}', $merc["price"], $html);
        $html = str_replace('{peculiarities}', getStringOfHtmlsOfPercualities($featureArr), $html);
        $html = str_replace('{description}', $merc["description"], $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}

function getStringOfHtmlsOfPercualities(array $arr): string
{
    $template = " <p><strong>{peculiarity}</strong></p>";
    $htmls = "";
    foreach ($arr as $item) {
        $html = $template;
        $html = str_replace('{peculiarity}', $item["feature"], $html);
        $htmls = $htmls . $html;
    }

    return $htmls;
}
<?php

$main_template = file_get_contents("./html/templ_main.html");

$header = file_get_contents("./html/header.html");
$content = file_get_contents("./html/mercenaryContent.html");
$footer = file_get_contents("./html/footer.html");

$add_to_head = '<link rel="stylesheet" href="../style/mercenaryStyle.css">';


$main_template= str_replace('{add_to_head}', $add_to_head, $main_template);
$main_template= str_replace('{header}', $header, $main_template);
$main_template= str_replace('{content}', $content, $main_template);
$main_template= str_replace('{footer}', $footer, $main_template);

echo $main_template;
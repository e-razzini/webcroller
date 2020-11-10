<?php

// configuração de proxy SENAI
$proxy = '10.1.21.254:3128';
$arrayP = array();
$arrayPConfig = array(

    'http' => array(

        'proxy' => $proxy,
        'request_fulluri' => true
    ),

    'https' => array(
        'proxy' => $proxy,
        'request_fulluri' => true
    )
);

$context = stream_context_create($arrayPConfig);
//------- configuração de PROXY
$url = 'https://www.gutenberg.org/';

$caputraHtml = file_get_contents($url, false, $context);



//echo $caputraHtml;
$dom = new DOMDocument();
libxml_use_internal_errors(true);
//transforma o html em objeto
$dom->loadHTML($caputraHtml);
libxml_clear_errors();

// captura as tags p
$tagsDiv = $dom->getElementsByTagName('div');
//$tagsP =$dom->getElementsByTagName('p');

//foreach imprime todas as tags P
// foreach($tagsP as $p){
//     echo $p->nodeValue;
//     echo "<br></br>";
// }
foreach ($tagsDiv as $div) {

    $class = $div->getAttribute('class');

    if ($class == 'page_content') {

        $divsInternas = $div->getElementsByTagName('div');

        foreach ($divsInternas as $divInterna) {

            $classInterna = $divInterna->getAttribute('class');

            if ($classInterna == 'box_announce') {

                $tagPInternas = $divInterna->getElementsByTagName('p');

                //echo $divInterna->nodeValue;
                foreach ($tagPInternas as $tagP) {

                    $arrayP[] = $tagP->nodeValue;
                }
            }
        }
    }
}

print_r($arrayP);

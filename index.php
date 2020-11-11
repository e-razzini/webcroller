<?php

// configuração de proxy SENAI
$proxy = '10.1.21.254:3128';
$arrayParagrafos = [];
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

$tagsDiv = $dom->getElementsByTagName('div');
// captura as tags p
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
                
                foreach ($tagPInternas as $tagP) {

                  $arrayParagrafos[] = $tagP->nodeValue;
                }
            break;
        }
    }
break;
    }
}


/*print_r($arrayParagrafos);
 foreach ($arrayParagrafos as $key => $value) {
     echo $value . "<br>" ;
 }
 $arrayParagrafos = (objeto) $objetoData ;
foreach ($arrayParagrafos as $key => $value) {
    # code...
}
*/
<?php

class PlacarFutebol
{

    private $url;
    private $proxy;
    private $dom;
    private $html;

    public function __construct()
    {
        $this->proxy = '10.1.21.254:3128';
        $this->url = 'https://www.placardefutebol.com.br/';
        $this->dom =  new DOMDocument();
    }


    public function getDados(){

       $this->carregarHtml();
       $tagsDiv =$this->capturaTagsDiGeral();
       $divsInternas =$this->divInternas($tagsDiv);
       $tagsP = $this->capturarTagsP($divsInternas);
       $paragrafosArray = $this->getDados($tagsP);
       return $paragrafosArray;

    }

    private function getContextoConexao()
    {
        $arrayPConfig = array(

            'http' => array(

                'proxy' => $this->proxy,
                'request_fulluri' => true
            ),

            'https' => array(
                'proxy' => $this->proxy,
                'request_fulluri' => true
            )
        );

        $context = stream_context_create($arrayPConfig);

        return $context;
    }
    private function carregarHtml()
    {

      //  $context = $this->getContextoConexao();
        // usar somente onde tem que haver configuração de proxy
        //$this->html = file_get_contents($this->url, false, $context);
        $this->html = file_get_contents($this->url);

        libxml_use_internal_errors(true);

        //transforma o html em objeto
        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
    }

    private function capturaTagsDiGeral()
    {

        $tagsDivGeral = $this->dom->getElementsByTagName('div');
        return $tagsDivGeral;
    }
    private function divInternas($divGeral)
    {

        $divsInternas = null;

        foreach ($divGeral as  $div) {

            $classe = $div->getAttribute('class');

            if ($classe == 'match-card-league-name') {
                $divInternas = $div->getElementsByTagName('div');
                break;
            }
        }

        return $divInternas;
    }
    private function capturarTagsP($divInternas)
    {
        $tagsP = null;

        foreach ($divInternas as $divInterna) {
            $classeInterna = $divInterna->getAttribute('class');

            if ($classeInterna == 'box_announce') {
                $tagsP = $divInterna->getElementsByTagName('p');
            }
            # code...
        }
        return $tagsP;
    }

    private function getArrayParagrafos($tagsP)
    {

        $arrayDeParagrafos = [];
        foreach ($tagsP as $paragrafo) {
            $arrayDeParagrafos[] = $paragrafo->nodeValue;
        }
        return $arrayDeParagrafos;
    }


}

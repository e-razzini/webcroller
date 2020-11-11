<?php

require './util/GutenbergCrawler.php';

$infos = new GutenbergCrawler();

$paragrafos =$infos->getDados();

print_r($paragrafos);
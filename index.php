<?php

$start = microtime(true);
//for ($i = 0; $i < 10000000; ++$i) {
    // do something
//}

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Warsaw');

define('ROOT_DIR', __DIR__);


require_once ROOT_DIR . '/vendor/yaml/sfYamlParser.php';

$oYamlParser = new sfYamlParser();

$file = ROOT_DIR . '/configuration.yaml';
$aConfig = $oYamlParser->parse(file_get_contents($file));

$file = ROOT_DIR . '/dataset.yml';
$aDataset = $oYamlParser->parse(file_get_contents($file));


//print_r($aDataset);

// package('Aya.Xhtml.Table');

require_once 'AyaXhtmlTable.php';

$oTable = new AyaXhtmlTable();

$oTable->configure($aConfig);

$oTable->assign($aDataset);

//print_r($oTable);

echo '<style>';
echo file_get_contents(ROOT_DIR . '/tables.css');
echo '</style>';

echo $oTable->render();


$total = microtime(true) - $start;
echo $total;
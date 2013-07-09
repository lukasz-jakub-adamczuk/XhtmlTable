<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

echo $oTable->render();


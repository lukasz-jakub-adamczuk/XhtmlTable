<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_DIR', __DIR__);


require_once ROOT_DIR . '/vendor/yaml/sfYamlParser.php';

$file = ROOT_DIR . '/configuration.yaml';

$oConf = new sfYamlParser();
$aDataset = $oConf->parse(file_get_contents($file));



// package('Aya.Xhtml.Table');

require_once 'AyaXhtmlTable.php';

$oTable = new AyaXhtmlTable();

$oTable->configure();

$oTable->assign($aDataset);

echo $oTable->render();


<?php

$start = microtime(true);
for ($i = 0; $i < 10000000; ++$i) {
    // do something
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Warsaw');

define('ROOT_DIR', __DIR__);


// require_once ROOT_DIR . '/vendor/yaml/sfYamlParser.php';

// $oYamlParser = new sfYamlParser();

// $file = ROOT_DIR . '/configuration.yaml';
// $aConfig = $oYamlParser->parse(file_get_contents($file));

// $file = ROOT_DIR . '/dataset.yml';
// $aDataset = $oYamlParser->parse(file_get_contents($file));

if (isset($_GET['example'])) {
    $sExample = $_GET['example'];
} else {
    $sExample = 'basic';
}

require_once ROOT_DIR . '/Aya/Yaml/AyaYamlLoader.php';

$file = ROOT_DIR . '/examples/'.$sExample.'.yml';
$aConfig = AyaYamlLoader::parse($file);

$file = ROOT_DIR . '/datasets/'.$sExample.'.yml';
if (!file_exists($file)) {
    $file = ROOT_DIR . '/datasets/basic.yml';
}
$aDataset = AyaYamlLoader::parse($file);

$file = ROOT_DIR . '/langs/pl/common.yml';
$aTexts = AyaYamlLoader::parse($file);

$file = ROOT_DIR . '/langs/pl/my-example.yml';
$aLocalTexts = AyaYamlLoader::parse($file);



//print_r($aDataset);

// package('Aya.Xhtml.Table');

require_once ROOT_DIR . '/Aya/Xhtml/Table/AyaXhtmlTable.php';

$oTable = new AyaXhtmlTable();

$oTable->configure($aConfig);

$oTable->assign($aDataset);

$oTable->translate($aTexts, $aLocalTexts);

//print_r($oTable);

echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta charset="utf-8" />';
echo '<title>Title of the document</title>';

echo '<link type="text/css" rel="stylesheet" href="tables.css" />';

echo '<style>';
//echo file_get_contents(ROOT_DIR . '/tables.css');
echo '</style>';
echo '</head>';

echo '<body>';
echo '<div style="padding: 25px;">';
echo '<a href="index.php?example=basic">Basic example</a> ' ;
echo '<a href="index.php?example=offer">Offer example</a> ' ;
echo '</div>';
echo $oTable->render();

$total = microtime(true) - $start;
echo (int)($total * 1000).'ms';

echo '</body>';

echo '</html>';

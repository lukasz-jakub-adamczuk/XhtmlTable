<?php

//namespace Symfony\Component;

//use Aya\Yaml\Parser;

//use Symfony\Component\Yaml\Parser;
//use Yaml\Yaml;


error_reporting(E_ALL);
ini_set('display_errors', 1);


//require_once '/Users/ash/Sites/XhtmlTable/vendor/yaml/sfYamlParser.php';
//require_once '/Users/ash/Sites/Yaml/Parser.php';

require_once '/home/ash/public_html/XhtmlTable/vendor/yaml/sfYamlParser.php';

//$file = '/Users/ash/Sites/XhtmlTable/configuration.yaml';

$file = '/home/ash/public_html/XhtmlTable/configuration.yaml';


$oConf = new sfYamlParser();
$aDataset = $oConf->parse(file_get_contents($file));

//print_r($array);


// require_once '/Users/ash/Sites/symfony1-1.4/lib/yaml/sfYamlParser.php';

// $oYamlParser = new sfYamlParser();
// $aConf = $oYamlParser->parse($file);

// print_r($oYamlParser);
// print_r($aConf);



// package('Aya.Xhtml.Table');

require_once 'AyaXhtmlTable.php';



$oTable = new AyaXhtmlTable();

$oTable->configure();

$oTable->assign($aDataset);

echo $oTable->render();


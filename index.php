<?php


//echo 'XHTMLTABLE';

//namespace Symfony\Component;

//use Aya\Yaml\Parser;

use Symfony\Component\Yaml\ParserYaml;
//use Yaml\Yaml;


error_reporting(E_ALL);
ini_set('display_errors', 1);


//require_once '/Users/ash/Sites/Yaml/Yaml.php';
//require_once '/Users/ash/Sites/Yaml/Parser.php';

$file = '/Users/ash/Sites/XhtmlTable/configuration.yaml';

if (file_exists($file)) {
	echo 'OK';
}

$array = Parser::parse($file);

print_r($array);


// require_once '/Users/ash/Sites/symfony1-1.4/lib/yaml/sfYamlParser.php';

// $oYamlParser = new sfYamlParser();
// $aConf = $oYamlParser->parse($file);

// print_r($oYamlParser);
// print_r($aConf);


require_once 'XhtmlTable.php';

$oTable = new XhtmlTable();


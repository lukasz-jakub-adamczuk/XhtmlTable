<?php

error_reporting(E_ALL);

echo 'XHTMLTABLE';



//use Symfony\Component\Yaml\Yaml;

//require_once '/Users/ash/Sites/Yaml/Yaml.php';
//require_once '/Users/ash/Sites/Yaml/Parser.php';

//Yaml::parse('/Users/ash/Sites/XhtmlTable/configuration.yaml');

$file = '/Users/ash/Sites/XhtmlTable/configuration.yaml';


require_once '/Users/ash/Sites/symfony1-1.4/lib/yaml/sfYamlParser.php';

$oYamlParser = new sfYamlParser();
$aConf = $oYamlParser->parse($file);

print_r($oYamlParser);


require_once 'XhtmlTable.php';

$oTable = new XhtmlTable();


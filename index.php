<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$aDataset = array(
    
)

echo 'AAA';
// package('Aya.Xhtml.Table');

require_once 'AyaXhtmlTable.php';


$oTable = new AyaXhtmlTable();

$oTable->configure();

$oTable->assign($aDataset);

$oTable->render();


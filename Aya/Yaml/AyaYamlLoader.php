<?php

class AyaSingleton {
	
	protected static $_instance;

	protected function __construct() {}

	protected function __clone() {}

	public static function getInstance() {
	    if(is_null(self::$_instance)) {
	        self::$_instance = new self();
	    }
	    return self::$_instance;
	}


}


class AyaYamlLoader extends AyaSingleton {

	public static function getInstance() {
	    if (is_null(self::$_instance)) {
	    	require_once dirname(dirname(__DIR__)) . '/vendor/yaml/sfYamlParser.php';
	        self::$_instance = new sfYamlParser();
	    }
	    return self::$_instance;
	}

	public static function parse($file) {
		
		$oYamlParser = self::getInstance();
		
		return $oYamlParser->parse(file_get_contents($file));
	}

}

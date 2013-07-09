<?php

abstract class AyaXhtmlTableCell {

	private $_sKey;
	
	private $_sType = 'text';
    
	private $_sValue;
	
	public function __construct() {

	}

	public function configure($sKey, $aParams) {
	    $this->_sKey = $sKey;
	    // params
		if (isset($_aParams['value'])) {
			$this->_sValue = $aParams['value'];
		} else {
		    $this->_sValue = 'Unknown';
		}
		
	}

	public function render($aRow) {
	    if (isset($aRow[$this->_sKey])) {
		    return '<td>'.$aRow[$this->_sKey].'<td>';
		} else {
		    return '<td>'.$this->_sValue.'<td>';
		}
	}

}

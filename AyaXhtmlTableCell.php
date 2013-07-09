<?php

abstract class AyaXhtmlTableCell {

	private $_sType;

	private $_sValue;


	public function __construct() {

	}

	public function configure($aParams) {
		if (isset($_aParams['value'])) {
			$this->_sValue = $aParams['value'];
		} else {
		    $this->_sValue = 'Unknown';
		}
		
	}

	public function render($aRow) {
	    if (isset($aRow[$this->_sValue])) {
		    return '<td>'.$aRow[$this->_sValue].'<td>';
		} else {
		    return '<td>'.$this->_sValue.'<td>';
		}
	}

}

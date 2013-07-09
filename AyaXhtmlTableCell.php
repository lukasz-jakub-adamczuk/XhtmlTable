<?php


class AyaXtmlTableCell {

	private $_sType;

	private $_sValue;


	public function __construct() {

	}

	public function configure($aParams) {
		if (isset($_aParams['value'])) {
			$this->_sValue = $aParams['value'];
		}
		
	}

	public function render() {
		return '<td>'.$this->_sValue.'<td>';
	}

}
<?php

class AyaXhtmlTableCellLink extends AyaXhtmlTableCell {

	protected $_sLink;
	
	protected $_sLinkId;
	
	protected $_sLinkHref;
	
	protected $_sLinkTarget;

	//protected function _afterConfigure(&$aParams) {}

	/* column operations */
	
	public function columnElement($mValue, &$aRow = null) {
		// przygotowanie linka
		$sLink = $this->_sBaseLink;

		if (isset($this->_sLink)) {
			if (is_array($this->_sLink)) {
				foreach ($this->_sLink as $k => $v) {
					$sLink .= (isset($aRow[$v]) ? $aRow[$v] : $v);
				}
			} else {
				$sLink .= $this->_sLink;
			}
		}

		return '<a href="'.$sLink.'">'.$mValue.'</a>';
	}
	
}

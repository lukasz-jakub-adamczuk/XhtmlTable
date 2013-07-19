<?php

class AyaXhtmlTableCellLink extends AyaXhtmlTableCell {

    protected $_sLink;
    
    protected $_sLinkId;
    
    protected $_sLinkHref;
    
    protected $_sLinkTarget;

    //protected function _afterConfigure(&$aParams) {}

    /* column operations */
    
    public function columnElement($mValue, &$aRow) {
    	if (isset($this->_sLink)) {
	    	return '<a href="'.$this->_sLink.'">'.$mValue.'</a>';
	    } else {
	    	return $mValue;
	    }
    }
    
}

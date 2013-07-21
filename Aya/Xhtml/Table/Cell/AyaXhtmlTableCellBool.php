<?php

class AyaXhtmlTableCellBool extends AyaXhtmlTableCell {

    protected $_aValues;
    
    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
    }
    
    /* column operations */

    public function columnElement($mValue, &$aRow = null) {
    	if (isset($this->_aTexts['values'][$mValue])) {
	    	return '<span>'.$this->_aTexts['values'][$mValue].'</span>';
	    } else {
	    	return $mValue;
	    }
    }

}

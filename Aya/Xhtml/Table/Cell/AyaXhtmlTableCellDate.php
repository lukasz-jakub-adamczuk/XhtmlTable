<?php

class AyaXhtmlTableCellDate extends AyaXhtmlTableCell {

    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
        $this->_sFormat = 'd-m-Y';
    }

    /* column operations */

    public function columnElement($mValue, &$aRow = null) {
        if (!empty($this->_sTitle)) {
            $sTitle = isset($this->_aTexts['titles'][$mValue]) ? ' title="'.$this->_aTexts['titles'][$mValue].'"' : ' title="'.$this->_sTitle.'"';
        } else {
            $sTitle = '';
        }
        
        // TODO date without quotes is parsed as timestamp
        if (is_int($mValue)) {
        	return date($this->_sFormat, (int)$mValue);
        } else {
        	return date($this->_sFormat, strtotime($mValue));
        }
    }

}

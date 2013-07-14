<?php

class AyaXhtmlTableCellDate extends AyaXhtmlTableCell {

    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
        //$this->_sFormat = 'Y-m-d';
        $this->_sFormat = 'd-m-Y';
    }
    
    protected function _renderElement($aRow, $iNumber) {
        $mValue = $this->columnValue($aRow);
        
        return date($this->_sFormat, (int)$mValue);
    }
    
}

<?php

class AyaXhtmlTableCellDate extends AyaXhtmlTableCell {

    protected function _beforeConfigure() {
        //$this->_sFormat = 'Y-m-d';
        $this->_sFormat = 'd-m-Y';
    }
    
    protected function _renderElement() {
        return date($this->_sFormat);
    }
    
}

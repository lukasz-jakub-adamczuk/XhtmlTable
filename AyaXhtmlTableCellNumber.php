<?php

class AyaXhtmlTableCellNumber extends AyaXhtmlTableCell {

    protected $_sUnit;
    
    protected function _beforeConfigure() {
        $this->_sAlign = 'right';
    }
    
}

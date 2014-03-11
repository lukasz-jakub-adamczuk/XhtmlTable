<?php

class AyaXhtmlTableCellCheckbox extends AyaXhtmlTableCell {

    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
        //$this->_sFormat = 'd-m-Y';
    }

    /* column operations */

    public function columnElement($mValue, &$aRow = null) {
        if (!empty($this->_sTitle)) {
            $sTitle = isset($this->_aTexts['titles'][$mValue]) ? ' title="'.$this->_aTexts['titles'][$mValue].'"' : ' title="'.$this->_sTitle.'"';
        } else {
            $sTitle = '';
        }

        return '<input type="checkbox" name="ids[]" value="'.$mValue.'" />';
    }

}

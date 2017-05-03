<?php

class AyaXhtmlTableCellTag extends AyaXhtmlTableCell {

    protected $_aTags;
    
    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
    }
    
    /* column operations */
    
    public function columnElement($mValue, &$aRow = null) {
        if (!empty($this->_sTitle)) {
            $sTitle = isset($this->_aTexts['titles'][$mValue]) ? ' title="'.$this->_aTexts['titles'][$mValue].'"' : ' title="'.$this->_sTitle.'"';
        } else {
            $sTitle = '';
        }
        
        if (isset($this->_aTags)) {
            if (isset($this->_aTags[$mValue])) {
                if (isset($this->_aTexts['values'][$mValue])) {
                    return '<span class="tag-'.$this->_aTags[$mValue].(isset($this->_sClass[$mValue]) ? ' '.$this->_sClass[$mValue] : '').'"'.$sTitle.'>'.$this->_aTexts['values'][$mValue].'</span>';
                } else {
                    return '<span class="tag-'.$this->_aTags[$mValue].(isset($this->_sClass[$mValue]) ? ' '.$this->_sClass[$mValue] : '').'"'.$sTitle.'>'.$mValue.'</span>';
                }
            } else {
                return $mValue;
            }
        } else {
            return $mValue;
        }
    }

}

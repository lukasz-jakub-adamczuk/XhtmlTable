<?php

class AyaXhtmlTableCellTag extends AyaXhtmlTableCell {

    protected $_aTags;
    
    protected function _beforeConfigure() {
        $this->_sAlign = 'center';
    }
    
    /* column operations */
    
    public function columnTags($mValue, &$aRow) {
        if (!empty($this->_sTitle)) {
            $sTitle = isset($this->_aTexts['titles'][$mValue]) ? ' title="'.$this->_aTexts['titles'][$mValue].'"' : ' title="'.$this->_sTitle.'"';
        } else {
            $sTitle = '';
        }
        
        if (isset($this->_aTags)) {
            if (isset($this->_aTags[$mValue])) {
                if (isset($this->_aTexts['values'][$mValue])) {
                    return '<span class="tag-'.$this->_aTags[$mValue].'"'.$sTitle.'>'.$this->_aTexts['values'][$mValue].'</span>';
                } else {
                    return '<span class="tag-'.$this->_aTags[$mValue].'"'.$sTitle.'>'.$mValue.'</span>';
                }
            } else {
                return $mValue;
            }
        } else {
            return $mValue;
        }
    }
    
    protected function _renderElement($aRow, $iCounter) {
        $mValue = parent::_renderElement($aRow, $iCounter);
        
        $mValue = $this->columnTags($mValue, $aRow);
        
        return $mValue;
    }

    public function render($aRow, $iCounter) {
        return '<td>'.$this->_renderElement($aRow, $iCounter).'</td>';
    }

}

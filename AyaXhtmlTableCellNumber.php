<?php

class AyaXhtmlTableCellNumber extends AyaXhtmlTableCell {

    protected $_sUnit;
    
    protected function _beforeConfigure() {
        $this->_sAlign = 'right';
    }
    
    /* column operations */
    
    public function columnElement($mValue, &$aRow = null) {
        /*$sUnit = '';
        if (isset($this->_sUnit)) {
            if (is_array($this->_sUnit)) {
                foreach ($this->_sUnit as $k => $v) {
                    $sUnit .= (isset($aRow[$v]) ? $aRow[$v] : $v);
                }
            } else {
                $sUnit .= $this->_sUnit;
            }
        }*/
        /*if ($mValue == -1) {
            return '&bull;';
        }*/
        if ($this->_sUnit) {
            return $mValue . '<span class="unit">'.$this->_sUnit.'</span>';
        } else {
            return $mValue;
        }
    }
    
}

<?php

abstract class AyaXhtmlTableCell {

    protected $_sKey;
    
    protected $_sType = 'text';
    
    protected $_sValue;
    
    protected $_sDefault;
    
    protected $_sFormat;
    
    // cell attrs
    protected $_sSortLink;
    
    protected $_sWidth;
    
    protected $_sAlign = 'left';
    
    protected $_sClass;

    protected $_sTitle;

    // cell props
    protected $_bEscape = false;
    
    protected $_bVisible = true;
    
    protected $_bSortable = true;
    
    public function __construct() {

    }

    public function configure($sKey, $aParams) {
        $this->_sKey = $sKey;
        // params
        if (isset($_aParams['value'])) {
            $this->_sValue = $aParams['value'];
        } else {
            $this->_sValue = 'Unknown';
        }
        
    }
    
    public function isVisible() {
        return $this->_bVisible;
    }
    
    /* setters */

    public function setValue($sValue) {
        $this->_sValue = $sValue;
    }
    
    public function setClass($sClass) {
        $this->_sClass = $sClass;
    }
    
    /* getters */
    
    public function getValue() {
        return $this->_sValue;
    }
    
    /* renders */
    
    public function renderHeadCell() {
    }
    
    public function renderFootCell() {
    }
    
    protected function _renderElement() {
    }

    public function render($aRow) {
        if (isset($aRow[$this->_sKey])) {
            return '<td>'.$aRow[$this->_sKey].'<td>';
        } else {
            return '<td>'.$this->_sValue.'<td>';
        }
    }

}

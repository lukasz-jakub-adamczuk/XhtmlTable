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
    
    protected function _beforeConfigure() {}
    
    protected function _afterConfigure(&$aParams) {}

    public function configure($sKey, $aParams) {
        $this->_sKey = $sKey;
        // params
        if (isset($_aParams['value'])) {
            $this->_sValue = $aParams['value'];
        } else {
            $this->_sValue = 'Unknown';
        }
        
        // default values (if not comes from params)
        $this->_beforeConfigure();
        
        // set all what comes from params
        if (isset($aParams)) {
            foreach ($aParams as $params => $param) {
                $this->set($params, $param);
            }
        }
        
        // overidden values (if comes from params)
        $this->_afterConfigure($aParams);
        
    }
    
    public function set($sName, $mValue) {
        $aPrefixes = array('s', 'b', 'a', 'i', 'd', 'm');
        foreach ($aPrefixes as $prefixes => $prefix) {
            $sProperty = '_'.$prefix.ucfirst($sName);
            if (property_exists(get_class($this), $sProperty)) {
                $this->$sProperty = $mValue;
                return true;
            }
        }
    }
    
    public function get($sName, $sDefault = null) {
        $aPrefixes = array('s', 'b', 'a', 'i', 'd', 'm');
        foreach ($aPrefixes as $prefixes => $prefix) {
            $sProperty = '_'.$prefix.ucfirst($sName);
            if (property_exists(get_class($this), $sProperty)) {
                return $this->$sProperty;
            }
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
        return '<th>'.$this->_sKey.'</th>';
    }
    
    public function renderFootCell() {
    }
    
    protected function _renderElement() {
    }

    public function render($aRow) {
        if (isset($aRow[$this->_sKey])) {
            return '<td>'.$aRow[$this->_sKey].'</td>';
        } else {
            return '<td>'.$this->_sValue.'</td>';
        }
    }

}

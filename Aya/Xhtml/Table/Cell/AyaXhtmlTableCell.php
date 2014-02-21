<?php

abstract class AyaXhtmlTableCell {

    protected $_sKey;
    
    protected $_sType = 'text';
    
    protected $_sValue;
    
    protected $_sDefault;
    
    protected $_sFormat;
    
    protected $_sTotal;

    protected $_aTexts = array();
    
    protected $_sAxis;
    
    // cell attrs
    protected $_sBaseLink;
    
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
            $this->_sValue = str_replace('-', '_', $sKey);
        }
        
        if ($this->_bSortable) {
            $this->_sAxis = str_replace('_', '-', $this->_sValue);
        }
        
        // default values (if not comes from params)
        $this->_beforeConfigure();
        
        // set all what comes from params
        if (is_array($aParams)) {
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

    public function translate($aTexts, $sKey = null) {
        if ($sKey) {
//            var_dump($this->_aTexts);
            $this->_aTexts[$sKey] = $aTexts;
        } else {
            $this->_aTexts = $aTexts;
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

    public function setBaseLink($sBaseLink) {
        $this->_sBaseLink = $sBaseLink;
    }
    
    /* getters */
    
    public function getValue() {
        return $this->_sValue;
    }
    
    /* column operations */
    
    public function columnValue(&$aRow, $sKey = null) {
        /*if ($sKey) {
            if (isset($aRow[$sKey])) {
                return $aRow[$sKey]; 
            }
        } else {*/
            if (isset($aRow[$this->_sValue])) {
                return $aRow[$this->_sValue]; 
            } else {
                return $this->_sValue;
            }
        //}
        return null;
    }
    
    public function columnDefault($mValue, &$aRow = null) {
        if (isset($this->_sDefault)) {
            $sDefault = is_null($mValue) ? $this->_sDefault : $mValue;
        } else {
            $sDefault = is_null($mValue) ? '&bull;' : $mValue;
        }
        return $sDefault;
    }
    
    public function columnEscape($mValue) {
        return $this->_bEscape ? htmlspecialchars(stripslashes($mValue)) : $mValue;
    }

    public function columnElement($mValue, &$aRow = null) {
        return $mValue;
    }
    
    /* renders */
    
    public function renderHeadCell($aNavigator, $sPreLink = '') {
        // if ($sPreLink) {
        //     $this->_sBaseLink = $sPreLink;
        // }
        return '<th id="'.$this->_sKey.'"'
        .(isset($this->_sWidth)
            ? ' width="'.$this->_sWidth.'"'
            : '')
        .(isset($this->_sAxis)
            ? ' axis="'.$this->_sAxis.'"'
            : '')
        .(isset($this->_sClass) || isset($this->_sAlign) || isset($aNavigator['sort'])
            ? ' class="'.(isset($this->_sClass)
                ? $this->_sClass
                : '')
            //.(isset($this->_sAlign)
              //  ? (' ta'.substr($this->_sAlign, 0, 1))
                //: '')
            .(isset($aNavigator['sort']) && ($aNavigator['sort'] == $this->_sKey || $aNavigator['sort'] == $this->_sAxis)
                ? ' sorted '.$aNavigator['order']
                : '')
            .'"'
            : '')
        .'>'
        .($this->_bSortable && isset($this->_sAxis)
            ? '<a href="'.$sPreLink.'/sort'.$this->_sBaseLink
            .'/'
            .(isset($this->_sAxis)
                ? $this->_sAxis
                : $this->_sKey)
            .(isset($aNavigator['sort']) && ($aNavigator['sort'] === $this->_sKey || $aNavigator['sort'] === $this->_sAxis)
                ? ($aNavigator['order'] == 'asc'
                    ? '/desc'
                    : '/asc')
                : (isset($aNavigator['order']) && $aNavigator['order'] == 'desc'
                    ? '/desc'
                    : '/asc'))
            .'"'
            .' class="'
            .(isset($aNavigator['sort']) && ($aNavigator['sort'] === $this->_sKey || $aNavigator['sort'] === $this->_sAxis)
                ? ''.$aNavigator['order']
                : '')
            .'"'
            .' title="'
            /*.(isset($aNavigator['sort']) && ($aNavigator['sort'] == $this->_sKey || $aNavigator['sort'] == $this->_sAxis)
                ? ($aNavigator['sort_dir'] == 'asc'
                    ? $this->_aTexts['common']['sort']['desc']
                    : $this->_aTexts['common']['sort']['asc'])
                : (isset($aNavigator['sort_dir']) && $aNavigator['sort_dir'] == 'desc'
                    ? $this->_aTexts['common']['sort']['desc']
                    : $this->_aTexts['common']['sort']['asc']))*/
            .'"'
            .'>'
            .(isset($this->_aTexts['cols']['name']) ? $this->_aTexts['cols']['name'] : $this->_sKey)
            .'</a>'
            : '<span>'.(isset($this->_aTexts['cols']['name']) ? $this->_aTexts['cols']['name'] : $this->_sKey).'</span>')
        .'</th>';
    }
    
    public function renderFootCell($aTotal) {
        $mValue = isset($aTotal[$this->_sKey]) ? $aTotal[$this->_sKey] : null;
        
        if ($mValue) {
//            $mValue = $this->columnMultiplier($mValue);
  //          $mValue = $this->columnDivider($mValue);
            //$mValue = $this->columnRound($mValue, &$col);
    //        $mValue = $this->columnFormat($mValue);
            //$mValue = $this->columnUnit($mValue);
            $mValue = $this->columnElement($mValue);
        }
        
        return '<td>'.$mValue.'</td>';
    }
    
    protected function _renderElement($aRow, $iCounter) {
        $mValue = $this->columnValue($aRow);
        $mValue = $this->columnDefault($mValue, $aRow);
        $mValue = $this->columnEscape($mValue);

        $mValue = $this->columnElement($mValue, $aRow);
        
        return $mValue;
    }

    public function render($aRow, $iCounter) {
        return '<td>'.$this->_renderElement($aRow, $iCounter).'</td>';
    }

}

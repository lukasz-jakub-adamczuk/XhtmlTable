<?php

class AyaXhtmlTableCellLink extends AyaXhtmlTableCell {

    protected $_sLink;
    
    protected $_sLinkId;
    
    protected $_sLinkHref;
    
    protected $_sLinkTarget;

    //protected function _afterConfigure(&$aParams) {}

    /* column operations */
    
    public function columnElement($mValue, &$aRow = null) {
        // przygotowanie linka
        // $sLink = (defined('LOCAL_URL') ? LOCAL_URL : '');
        // echo $this->_sSortLink;
        $sLink = $this->_sBaseLink;
        if (isset($this->_sLink)) {
            if (is_array($this->_sLink)) {
                foreach ($this->_sLink as $k => $v) {
                    //if (substr($v, 0, 5) == 'nav::') {
                    //    $sNav = substr($v, 5);
                    //    $sLink .= (isset($this->_aNavigator[$sNav]) ? $this->_aNavigator[$sNav] : $v);
                    //} else {
                        $sLink .= (isset($aRow[$v]) ? $aRow[$v] : $v);
                    //}
                }
            } else {
                $sLink .= $this->_sLink;
            }
        }
        //if ($this->_sIdLink) {
        //    $sLink .= (isset($aRow[$this->_sIdLink]) ? $aRow[$this->_sIdLink] : $this->_sIdLink);
        //}
        return '<a href="'.$sLink.'">'.$mValue.'</a>';
        /*
    	if (isset($this->_sLink)) {
    	}
	    	return '<a href="'.$this->_sLink.'">'.$mValue.'</a>';
	    } else {
	    	return $mValue;
	    }*/
    }
    
}

<?php

class AyaXhtmlTable {
    /**
    *
    * abc
    */
    private $_sId;
    
    private $_aRows;
    
    private $_aCols;

    private $_aDataset;
    
    private $_sLang = 'pl';
    
    private $_sTableCaption = '';
    
    private $_sTableSummary = '';
    
    public function __construct() {
        
    }
    
    public function configure() {

    }
    
    public function assign($aDataset) {
        $this->_aDataset = $aDataset;
    }
    
    public function render() {
        $s = '<table>';
        $s .= '<thead>';
        $s .= '<tr>';
        $s .= '<td>A</td><td>B</td><td>C</td>';
        $s .= '</tr>';

        $s .= '</head>';
        foreach ($this->_aDataset as $rows) {
            $s .= '<tr>';
            foreach ($rows as $cols) {
                $s .= '<td>'.$cols.'</td>';
            }
            $s .= '</tr>';
        }
        $s .= '<tfoot>';
        $s .= '</tfoot>';
        $s .= '<tbody>';
        $s .= '</tbody>';
        $s .= '</table>';
        return $s;
    }
}

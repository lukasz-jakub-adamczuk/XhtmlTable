<?php

class AyaXhtmlTable {
    /**
    *
    * abc
    */
    private $_sId;
    
    private $_aRows;
    
    private $_aCols;
    
    private $_sLang = 'pl';
    
    private $_sTableCaption = '';
    
    private $_sTableSummary = '';
    
    public function __construct() {
        
    }
    
    public function configure() {
    }
    
    public function assign() {
        
    }
    
    public function render() {
        $s = '<table>';
        $s .= '<tr>';
        $s .= '<td>A</td><td>B</td><td>C</td>';
        $s .= '</tr>';
        $s .= '</table>';
        return $s;
    }
}

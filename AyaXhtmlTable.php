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
    
    public function configure($aConfig) {
        //$this->_aCon

        require_once './AyaXhtmlTableCell.php';

        foreach ($aConfig['cells'] as $cells => $cell) {
            $aCells[$cells] = new AyaXhtmlTableCell();

            $aCells[$cells]->configure($cell);
        }
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
            foreach ($aCells as $cell) {
                $s .= $cell->render();
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

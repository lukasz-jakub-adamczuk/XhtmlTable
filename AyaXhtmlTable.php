<?php

class AyaXhtmlTable {
    /**
    *
    * abc
    */
    private $_sId;
    
    private $_aRows;
    
    private $_aCols;
    
    private $_aCells;

    private $_aDataset;

    private $_aTexts;
    
    private $_sLang = 'pl';
    
    private $_sTableCaption = '';
    
    private $_sTableSummary = '';
    
    public function __construct() {
        
    }
    
    public function configure($aConfig) {
        //
        
        // require parent class
        require_once dirname(__FILE__) . '/AyaXhtmlTableCell.php';
        
        // listing required classes
        foreach ($aConfig['cols'] as $cols => $col) {
            $sCellType = (isset($col['type']) ? $col['type'] : 'text');
            $aClasses[$sCellType] = 'AyaXhtmlTableCell'.ucfirst($sCellType);
        }
        
        // including required classes
        foreach ($aClasses as $sCellName) {
            if (!class_exists($sCellName, false)) {
                if (file_exists(dirname(__FILE__) . '/'.$sCellName.'.php')) {
                    require_once dirname(__FILE__) . '/'.$sCellName.'.php';   
                }
            }
        }
        
        foreach ($aConfig['cols'] as $cols => $col) {
            // naming
            $sCellType = (isset($col['type']) ? $col['type'] : 'text');
            $sCellName = 'AyaXhtmlTableCell'.ucfirst($sCellType);
            
            // creating
            if (class_exists($sCellName, false)) {
                $this->_aCells[$cols] = new $sCellName(str_replace(' ', '', ucwords(str_replace('-', ' ', $this->_sId))));
            } else {
                $this->_aCells[$cols] = new AyaXhtmlTableCellText(str_replace(' ', '', ucwords(str_replace('-', ' ', $this->_sId))));
            }
            
            // configuring cell
            $this->_aCells[$cols]->configure($cols, $col);
        }
    }
    
    public function assign($aDataset) {
        $this->_aDataset = $aDataset;
    }
    
    public function render() {
        $s = '<table>';
        // thead
        $s .= '<thead>';
            $s .= '<tr>';
            foreach ($this->_aCells as $cell) {
                if ($cell->isVisible()) {
                    $s .= $cell->renderHeadCell();
                }
            }
            $s .= '</tr>';
        $s .= '</head>';
        // tfoot
        $s .= '<tfoot>';
        $s .= '</tfoot>';
        // tbody
        $s .= '<tbody>';
        foreach ($this->_aDataset as $rows => $row) {
            $s .= '<tr>';
            foreach ($this->_aCells as $cell) {
                $s .= $cell->render($row);
            }
            $s .= '</tr>';
        }
        $s .= '</tbody>';
        $s .= '</table>';
        return $s;
    }
}

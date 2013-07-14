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
    
    private $_aTotal;

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
            
            // preparing to count total
            if (isset($col['total'])) {
                $this->_aTotal['conf'][$cols] = $col['total'];
            }
        }
    }
    
    public function assign($aDataset) {
        $this->_aDataset = $aDataset;
    }
    
    private function _columnsAlignment() {
        $sAlignment = '';
        $i = 1;
        
        foreach ($this->_aCells as $cells => $cell) {
            // only visible cols
            if ($cell->isVisible()) {
                if (($sAlign = $cell->get('align')) != 'left') {
                    $sAlignment .= ' c'.$i.$sAlign[0];
                }
                $i++;
            }
        }
        return $sAlignment;
    }
    
    public function renderTotal($aCols = null) {
        $aCols = $aCols ? $aCols : $this->_aCols;
        $iRows = count($this->_aDataset);
        
        foreach ($aCols as $cols => $col) {
            if (isset($this->_aCells[$cols])) {
                $this->_aTotal['values'][$cols] = 0;
                foreach ($this->_aDataset as $rows => $row) {
                    $this->_aTotal['values'][$cols] += $row[$cols];
                }
                if ($this->_aTotal['conf'][$cols] == 'avg') {
                    $this->_aTotal['values'][$cols] /= $iRows;
                }
            }
        }
    }
    
    
    public function render() {
        // pre render
        $this->renderTotal($this->_aTotal['conf']);
        
        // html table code
        $s = '<table class="'.$this->_columnsAlignment().'">';
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
        if (!empty($this->_aTotal['values'])) {
            $s .= '<tfoot>';
                $s .= '<tr>';
                foreach ($this->_aCells as $cell) {
                    if ($cell->isVisible()) {
                        $s .= $cell->renderFootCell($this->_aTotal['values']);
                    }
                }
                $s .= '</tr>';
            $s .= '</tfoot>';
        }
        // tbody
        $s .= '<tbody>';
        $i = 1; // internal counter
        foreach ($this->_aDataset as $rows => $row) {
            $s .= '<tr>';
            foreach ($this->_aCells as $cell) {
                $s .= $cell->render($row, $i);
            }
            $s .= '</tr>';
            $i++;
        }
        $s .= '</tbody>';
        $s .= '</table>';
        return $s;
    }
}

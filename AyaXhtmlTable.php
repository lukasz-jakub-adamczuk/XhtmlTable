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
    
    private static function _columnsAlignment() {
        $sAlignment = '';
        $i = 1;
        
        print_r($this->_aCells);
        
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
    /*
    public static function renderTotal($aCols = null) {
        $aCols = $aCols ? $aCols : self::$_aCols;
        foreach ($aCols as $cols => $col) {
            if (isset(self::$_aCells[$col])) {
                self::$_aTotal[$col] = 0;
                foreach (self::$_aRows as $rows => $row) {
                    self::$_aTotal[$col] += $row[self::$_aCells[$col]->getValue()];
                }
            }
        }
    }
    
    public static function renderAverage($aCols = null) {
        $aCols = $aCols ? $aCols : self::$_aCols;
        foreach ($aCols as $cols => $col) {
            if (isset(self::$_aCells[$col])) {
                self::$_aTotal[$col] = 0;
                foreach (self::$_aRows as $rows => $row) {
                    self::$_aTotal[$col] += $row[self::$_aCells[$col]->getValue()];
                }
                self::$_aTotal[$col] /= count(self::$_aRows);
            }
        }
    }*/
    
    public function render() {
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

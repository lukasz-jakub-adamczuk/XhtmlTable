<?php

class AyaXhtmlTable {
	
	private $_sId;
	
	private $_aRows;
	
	private $_aCols;
	
	private $_aCells;

	private $_aDataset;
	
	private $_aTotal;

	private $_aTexts;
	
	private $_aNavigator = array();
	
	private $_sLang = 'pl';
	
	private $_sTableCaption = '';
	
	private $_sTableSummary = '';
	
	private $_sTableSortLink = '';

	private $_sTableBaseLink = '';

	private $_sTableDateFormat = 'm-d-Y';
	
	public function __construct() {
		
	}
	
	public function configure($aConfig) {
		//
		
		// require parent class
		require_once dirname(__FILE__) . '/Cell/AyaXhtmlTableCell.php';
		
		// listing required classes
		foreach ($aConfig['cols'] as $cols => $col) {
			$sCellType = (isset($col['type']) ? $col['type'] : 'text');
			$aClasses[$sCellType] = 'AyaXhtmlTableCell'.ucfirst($sCellType);
			//$aNames[$cols] = 'AyaXhtmlTableCell'.ucfirst($sCellType);
		}

		// print_r($aClasses);
		
		// including required classes
		foreach ($aClasses as $sCellName) {
			if (!class_exists($sCellName, false)) {
				if (file_exists(dirname(__FILE__) . '/Cell/'.$sCellName.'.php')) {
					require_once dirname(__FILE__) . '/Cell/'.$sCellName.'.php';   
				}
			}
		}
		
		// creating cells objects
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
			
			// set default date format
			if ($sCellType === 'date') {
				$this->_aCells[$cols]->set('format', $this->_sTableDateFormat);
			}
			
			// configuring cell
			$this->_aCells[$cols]->configure($cols, $col);
			
			// preparing to count total
			if (isset($col['total'])) {
				$this->_aTotal['conf'][$cols] = $col['total'];
			}
		}
	}
	
	public function assign($aDataset, $aNavigator = null) {
		$this->_aDataset = $aDataset;
		if ($aNavigator) {
			$this->_aNavigator = $aNavigator;
		}
	}

	// specific texts overrides values from basic texts
	public function translate($aBasicTexts, $aSpecificTexts = null) {
		// setting basic texts
		$this->_aTexts = $aBasicTexts;
		// print_r($aBasicTexts);
		// overrides basic by specific
		if ($aSpecificTexts) {
			//$this->_aTexts = $this->_overrideTexts($aSpecificTexts);
			$this->_overrideTexts($aSpecificTexts);
			//$this->_overrideBaseByValues($this->_aTexts, $aSpecificTexts);
		}

		if (isset($this->_aTexts['caption'])) {
			$this->_sTableCaption = $this->_aTexts['caption'];
		}
		if (isset($this->_aTexts['summary'])) {
			$this->_sTableSummary = $this->_aTexts['summary'];
		}

		// TODO cache manager
		// all what is need cache and use next time
		// print_r($this->_aTexts);

		// column texts
		// TODO could be moved to private method
		foreach ($this->_aCells as $ck => $cell) {
			// checking does texts exists
			if (isset($this->_aTexts['cols'][$ck])) {
				$cell->translate($this->_aTexts['cols'][$ck], 'cols');
			}
			if (isset($this->_aTexts['values'][$ck])) {
				$cell->translate($this->_aTexts['values'][$ck], 'values');
			}/*
			if (isset($this->_aTexts['titles'])) {
				$cell->translate($this->_aTexts['titles'], 'titles');
			}*/
		}
	}

	// TODO change to recurssion
	private function _overrideTexts($aTexts) {
		foreach ($aTexts as $key => $value) {
			// cols level
			if (isset($this->_aTexts[$key])) {
				// try override
				foreach ($value as $val => $v) {
					// title level
					if (isset($this->_aTexts[$key][$val])) {
						foreach ($v as $k2 => $v2) {
							// params level
							$this->_aTexts[$key][$val][$k2] = $v2;
						}
					} else {
						$this->_aTexts[$key][$val] = $v;
					}
				}
			} else {
				// create
				$this->_aTexts[$key] = $value;
			}
		}
	}
	

	private function _overrideBaseByValues($aBase, $aValues) {
		foreach ($aValues as $key => $value) {
			if (isset($aBase[$key])) {
				// try override
				$this->_overrideBaseByValues($aBase[$key], $value);
			} else {
				// create
				$aBase[$key] = $value;
			}
		}
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
	
	/* setters */
	
	public function setSortLink($sSortLink) {
		$this->_sTableSortLink = $sSortLink;
	}

	public function setBaseLink($sBaseLink) {
		$this->_sTableBaseLink = $sBaseLink;
	}
	
	/* renders */
	
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
		if (isset($this->_aTotal['conf'])) {
			$this->renderTotal($this->_aTotal['conf']);
		}
		
		// table
		$s = '<table class="table '.$this->_columnsAlignment().'" summary="'.$this->_sTableSummary.'">';
		$s .= '<caption>'.$this->_sTableCaption.'</caption>';
		// cols
		// $s .= '<colgroup>';
		foreach ($this->_aCells as $cols => $cell) {
			if ($cell->isVisible()) {
				$s .= '<col'.($cols == 'title' ? ' class="selected"' : '').' />';
			}
		}
		// $s .= '</colgroup>';
		// thead
		$s .= '<thead>';
			$s .= '<tr>';
			foreach ($this->_aCells as $cell) {
				if ($cell->isVisible()) {
					// $sPreLink = defined('LOCAL_URL') ? LOCAL_URL : '';
					// echo $this->_sTableSortLink;
					
					$s .= $cell->renderHeadCell($this->_aNavigator, $this->_sTableSortLink);
					$cell->setBaseLink($this->_sTableBaseLink);
					// $s .= $this->_sTableSortLink;
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
			/*if ($row['deleted'] == '1') {
				$s .= '<tr class="deleted">';
			} else {
				$s .= '<tr>';
			}*/
			$s .= '<tr>';
			foreach ($this->_aCells as $cell) {
				if ($cell->isVisible()) {
					$s .= $cell->render($row, $i);
				}
			}
			$s .= '</tr>';
			$i++;
		}
		$s .= '</tbody>';
		$s .= '</table>';
		return $s;
	}
}

<?php

class AyaXhtmlTableCellText extends AyaXhtmlTableCell {

    /* column operations */

    public function columnElement($mValue, &$aRow = null) {
        // long texts were truncated automaticlly
        return substr($mValue, 0, 100);
    }
}

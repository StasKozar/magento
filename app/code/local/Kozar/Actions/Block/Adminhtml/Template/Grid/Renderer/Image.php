<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 19/10/2016
 * Time: 13:28
 */
class Kozar_Actions_Block_Adminhtml_Template_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }
    protected function _getValue(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $url = Mage::getBaseUrl('media') . 'kozar_actions/' . $val;
        $out = "<img src=". $url ." width='50px' height='50px'/>";
        return $out;
    }
}
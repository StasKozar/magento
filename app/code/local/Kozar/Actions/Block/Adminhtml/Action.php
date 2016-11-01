<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 17:10
 */
class Kozar_Actions_Block_Adminhtml_Action extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('kozar_actions');
        $this->_blockGroup = 'kozar_actions';
        $this->_controller = 'adminhtml_action';

        $this->_headerText = $helper->__('Actions Management');
        $this->_addButtonLabel = $helper->__('Add Action');

        return $this;
    }
}
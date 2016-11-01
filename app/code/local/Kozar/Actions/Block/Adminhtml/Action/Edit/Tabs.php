<?php


class Kozar_Actions_Block_Adminhtml_Action_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        $helper = Mage::helper('kozar_actions');

        parent::__construct();
        $this->setId('action_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($helper->__('Action Information'));

        return $this;
    }

    protected function _prepareLayout()
    {
        $helper = Mage::helper('kozar_actions');

        $this->addTab('general_section', array(
            'label' => $helper->__('General information'),
            'title' => $helper->__('General information'),
            'content' => $this->getLayout()->createBlock('kozar_actions/adminhtml_action_edit_tab_general')->toHtml(),
        ));
        $this->addTab('product_section', array(
            'class' => 'ajax',
            'label' => $helper->__('Product'),
            'title' => $helper->__('Product'),
            'url' => $this->getUrl('*/*/product', array('_current' => true)),
        ));

        return parent::_prepareLayout();
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 11:43
 */
class Kozar_Actions_Model_Action extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        parent::_construct();
        $this->_init('kozar_actions/action');
    }

    protected function _beforeLoad($id, $field = null)
    {
        $helper = Mage::helper('kozar_actions');
        $helper->convertToLocal($this);

        return parent::_beforeLoad($id);
    }

    protected function _beforeSave()
    {
        $helper = Mage::helper('kozar_actions');
        $helper->convertToGmt($this);
        $helper->setStatus($this);

        return parent::_beforeSave();
    }

    public function getImageUrl()
    {
        $helper = Mage::helper('kozar_actions');
        if ($this->getImage()) {
            return $helper->getImageUrl($this->getImage());
        }
        return $this;
    }

    public function getProducts()
    {
        return Mage::getResourceModel('kozar_actions/action')->getProductsCollection($this);//Kozar_Actions_Model_Resource_Action::getProductsCollection($this);
    }

    public function getActionUrl()
    {
        return Mage::getUrl('actions/index/view', array(
            'id' => $this->getId(),
        ));
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 18/10/2016
 * Time: 8:54
 */
class Kozar_Actions_Model_Product extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('kozar_actions/product');
        return $this;
    }

    public function getActionsCollection($productId)
    {
        $relActionCollection = Mage::getModel('kozar_actions/product')->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->getColumnValues('action_id');

        $collection = Mage::getModel('kozar_actions/action')->getCollection()
            ->addFieldToFilter('status', Kozar_Actions_Model_Source_Boolean::OPEN_ACTION);
        if(count($relActionCollection) > 0){
            $collection->addFieldToFilter('id', array('in' => $relActionCollection));
        }else{
            $collection->addFieldToFilter('id', array('nin' => $relActionCollection));
        }

        return $collection;
    }
}
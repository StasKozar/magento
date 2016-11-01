<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 25/10/2016
 * Time: 13:42
 */
class Kozar_Actions_Block_Product_View_Actions extends Mage_Core_Block_Template
{
    protected $_product = null;

    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }
        return $this->_product;
    }

    public function getActionsCollection($productId)
    {
        $relActionCollection = Mage::getModel('kozar_actions/product')->getCollection();
        $relActionCollection->addFieldToFilter('product_id', $productId);
        $relActions = array();
        foreach ($relActionCollection as $item){
            $relActions[] = $item->getActionId();
        }
        $collection = Mage::getModel('kozar_actions/action')->getCollection();
        if(!empty($relActions)){
            $collection->addFieldToFilter('id', array('in' => $relActions));
        }else{
            $collection->addFieldToFilter('id', array('nin' => $relActions));
        }

        return $collection;
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 11:44
 */
class Kozar_Actions_Model_Resource_Action extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('kozar_actions/action', 'id');
        return $this;
    }

    public function getProductsCollection($model)
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->joinField('action_id',
                'kozar_actions/product',
                'action_id',
                'product_id=entity_id',
                null,
                'left')
            ->addFilter('action_id', $model->getId());
        $collection->getSelect()->group('e.entity_id');

        /*foreach ($collection as $item){
            var_dump($item);
            die();
        }*/

        return $collection;
    }
}
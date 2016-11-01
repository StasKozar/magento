<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 20/10/2016
 * Time: 8:50
 */
class Kozar_Actions_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('kozar_actions/product', 'id');
        return $this;
    }
}
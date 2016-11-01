<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 11:47
 */
class Kozar_Actions_Model_Resource_Action_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('kozar_actions/action');
        return $this;
    }
}
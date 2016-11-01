<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 15:39
 */
class Kozar_Actions_Block_Action_View extends Mage_Core_Block_Template
{
    public function getActionsAction()
    {
        return Mage::registry('kozar_actions_action');
    }

    public function getActionProducts()
    {
        return Mage::registry('kozar_actions_action_products');
    }
}
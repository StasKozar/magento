<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 11:24
 */
class Kozar_Actions_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $actionId = Mage::app()->getRequest()->getParam('id', 0);
        $action = Mage::getModel('kozar_actions/action')->load($actionId);
        $products = $action->getProducts()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('visibility')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('sku');

        if($action->isObjectNew() || $action->getStatus() != Kozar_Actions_Model_Source_Status::OPEN_ACTION){
            return $this->norouteAction();
        }

        Mage::register('kozar_actions_action', $action);
        Mage::register('kozar_actions_action_products', $products);

        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }
}
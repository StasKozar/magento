<?php

class Tsg_Request_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $requestId = Mage::app()->getRequest()->getParam('id', 0);
        $request = Mage::getModel('tsg_request/get')->load($requestId);
        $requests = $request->getRelativeRequests();

        Mage::register('tsg_request_get', $request);
        Mage::register('tsg_request_get_relative', $requests);

        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }
}
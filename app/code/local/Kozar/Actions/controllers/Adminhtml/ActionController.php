<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 16:55
 */
class Kozar_Actions_Adminhtml_ActionController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('kozar_actions');
        $this->_addContent($this->getLayout()->createBlock('kozar_actions/adminhtml_action'));
        $this->renderLayout();

        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
        return $this;
    }

    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('kozar_actions/action');

        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $model->setData($data)->setId($id);
        }else{
            $model->load($id);
        }


        Mage::register('current_action', $model);

        $this->loadLayout()->_setActiveMenu('kozar_actions');
        $this->_addLeft($this->getLayout()->createBlock('kozar_actions/adminhtml_action_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('kozar_actions/adminhtml_action_edit'));
        $this->renderLayout();

        return $this;
    }

    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        $helper = Mage::helper('kozar_actions');

        if($data = $this->getRequest()->getPost()){
            try {
                $model = Mage::getModel('kozar_actions/action');

                $model->setData($data)->setId($id);

                if($model->isObjectNew()){
                    $model->setData($data)->setCreateDatetime(Mage::getModel('core/date')->date());
                }

                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $fileName = $_FILES['image']['name'];
                    $uploader->save($helper->getImagePath(), $fileName);
                    $model->setImage($uploader->getUploadedFileName());
                }else{
                    $model->setImage(null);
                }

                $model->save();

                $actionId = $model->getId();

                $this->saveSelectedProducts($actionId);

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            if (isset($data['image']['delete']) && $data['image']['delete'] == 1){
                $imageName = explode('/', $data['image']['value']);

                $helper->deleteImage(array_pop($imageName));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if($id = $this->getRequest()->getParam('id')){
            try {
                Mage::helper('kozar_actions')->deleteImage(Mage::getModel('kozar_actions/action')->load($id)->getImage());
                Mage::getModel('kozar_actions/action')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was deleted successfully'));
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');

        return $this;
    }

    public function massDeleteAction()
    {
        $action = $this->getRequest()->getParam('action', null);

        if(is_array($action) && sizeof($action) > 0)
        {
            try{
                foreach ($action as $id){
                    Mage::getModel('kozar_actions/action')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d actions have been deleted', sizeof($action)));
            }catch (Exception $e){
                $this->_getSession()->addError($e->getMessage());
            }
        }else{
            $this->_getSession()->addError($this->__('Please select posts'));
        }
        $this->_redirect('*/*');

        return $this;
    }

    public function productAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('kozar_actions/action')->load($id);
        $request = Mage::app()->getRequest();

        Mage::register('current_action', $model);

        if ($request->isAjax()) {

            $this->loadLayout();
            $layout = $this->getLayout();

            $root = $layout->createBlock('core/text_list', 'root', array('output' => 'toHtml'));

            $grid = $layout->createBlock('kozar_actions/adminhtml_action_edit_tab_product');
            $root->append($grid);

            if (!$request->getParam('grid_only')) {
                $serializer = $layout->createBlock('adminhtml/widget_grid_serializer');
                $serializer->initSerializerBlock($grid, 'getSelectedProducts', 'selected_products', 'selected_products');
                $root->append($serializer);
            }

            $this->renderLayout();
        }

        return $this;
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'create':
                return Mage::getSingleton('admin/session')->isAllowed('kozar_actions/actions/save');
                break;
            case 'edit':
                return Mage::getSingleton('admin/session')->isAllowed('kozar_actions/actions/edit');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('kozar_actions/actions/delete');
                break;
            case 'massDelete':
                return Mage::getSingleton('admin/session')->isAllowed('kozar_actions/actions/massDelete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('kozar_actions/actions');
                break;
        }
    }

    public function saveSelectedProducts($actionId){
        $actionProducts = Mage::getModel('kozar_actions/product')->getCollection()
            ->addFieldToFilter('action_id', $actionId);

        if ($selectedProducts = $this->getRequest()->getParam('selected_products', null)) {
            foreach ($actionProducts as $item) {
                $item->delete();
            }
            $selectedProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($selectedProducts);
            foreach($selectedProducts as $id){
                Mage::getModel('kozar_actions/product')->setProductId($id)->setActionId($actionId)->save();
            }
        }
    }
}
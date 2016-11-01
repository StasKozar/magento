<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 13/10/2016
 * Time: 13:40
 */
class Kozar_Actions_Block_Adminhtml_Action_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'kozar_actions';
        $this->_controller = 'adminhtml_action';

        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
        $this->_updateButton('save', 'label', Mage::helper('kozar_actions')->__('Save Action'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        return $this;
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('kozar_actions');
        $model = Mage::registry('current_action');

        if($model->getId()){
            return $helper->__("Edit Action item '%s'", $this->escapeHtml($model->getName()));
        }else{
            return $helper->__('Add Action item');
        }
    }
}
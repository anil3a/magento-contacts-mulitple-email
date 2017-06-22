<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Adminhtml_Contactsus_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'contactsus';
        $this->_controller = 'adminhtml_contactsus';
        
        $this->_updateButton('delete', 'label', Mage::helper('contactsus')->__('Delete Message'));
		$this->_removeButton('save');
        $this->_removeButton('reset');

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('contactsus_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'contactsus_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'contactsus_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('contactsus_data') && Mage::registry('contactsus_data')->getId() ) {
            return Mage::helper('contactsus')->__("View message from '%s'", $this->htmlEscape(Mage::registry('contactsus_data')->getName()));
        } else {
            return Mage::helper('contactsus')->__('Add Message');
        }
    }
}
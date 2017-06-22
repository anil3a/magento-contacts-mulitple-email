<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Adminhtml_Contactsus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contactsus_form', array('legend'=>Mage::helper('contactsus')->__('Message detail')));
     
      $fieldset->addField('email', 'label', array(
          'label'     => Mage::helper('contactsus')->__('Email'),
          'name'      => 'email',
      ));
      
      
     $fieldset->addField('message', 'editor', array(
          'name'      => 'message',
          'label'     => Mage::helper('contactsus')->__('Message'),
          'title'     => Mage::helper('contactsus')->__('Message'),
          'style'     => 'width:500px; height:350px',
          'wysiwyg'   => false,
          'required'  => true,
      ));
		

  
      if ( Mage::getSingleton('adminhtml/session')->getContactsusData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getContactsusData());
          Mage::getSingleton('adminhtml/session')->setContactsusData(null);
      } elseif ( Mage::registry('contactsus_data') ) {
          $form->setValues(Mage::registry('contactsus_data')->getData());
      }
      return parent::_prepareForm();
  }
}
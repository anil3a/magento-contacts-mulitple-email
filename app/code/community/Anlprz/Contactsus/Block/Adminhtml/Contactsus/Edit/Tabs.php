<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Adminhtml_Contactsus_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('contactsus_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('contactsus')->__('Message Detail'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('contactsus')->__('Message Detail'),
          'title'     => Mage::helper('contactsus')->__('Message Detail'),
          'content'   => $this->getLayout()->createBlock('contactsus/adminhtml_contactsus_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
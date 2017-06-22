<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Quickcontact extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getContactsus()     
     { 
        if (!$this->hasData('contactsus')) {
            $this->setData('contactsus', Mage::registry('contactsus'));
        }
        return $this->getData('contactsus');
        
    }
}
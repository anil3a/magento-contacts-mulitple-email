<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Form extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addCss('css/Contactsus/Contactsus_default.css');
        return parent::_prepareLayout();
    }
    
     public function getContactsus()
     { 
        if (!$this->hasData('Contactsus')) {
            $this->setData('Contactsus', Mage::registry('Contactsus'));
        }
        return $this->getData('Contactsus');
     }
}
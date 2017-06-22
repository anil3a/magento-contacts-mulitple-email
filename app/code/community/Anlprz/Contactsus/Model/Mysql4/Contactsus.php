<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Model_Mysql4_Contactsus extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('contactsus/contactsus', 'contactemails_id');
    }
}
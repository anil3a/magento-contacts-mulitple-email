<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Model_Contactsus extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('contactsus/contactsus');
    }
    
    public function setDataTemplateForStoring( $data = array() ){
        
        if( !empty( $data )){
            
            $storing_data = "";
            $storing_data_email = "";
            
            foreach ( $data as $field => $value ){
                if( $field != 'hideit' ){
                    $storing_data .= "".$field."\n";
                    $storing_data .= "".$value."\n\n";
                }
                if( $field == 'email') {
                    $storing_data_email = $value;
                }
            }
            return array( 'message' => $storing_data, 'customer_email' => $storing_data_email );
        }
        return false;
        
    }
    
}
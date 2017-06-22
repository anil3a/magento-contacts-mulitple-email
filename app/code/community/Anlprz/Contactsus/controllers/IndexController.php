<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

require_once Mage::getModuleDir('controllers', "Mage_Contacts").DS."IndexController.php";

class Anlprz_Contactsus_IndexController extends Mage_Contacts_IndexController
{
    public function preDispatch()
    {
        parent::preDispatch();
        if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function indexAction()
    {
       parent::indexAction();
    }

    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);
                
                
                
                $model = Mage::getModel('contactsus/contactsus');
                
                $contact_form_data = $model->setDataTemplateForStoring($post);
                
                $isSaveEnabled = Mage::getStoreConfig('contactsus/general/enable_save');
                
                if($isSaveEnabled){
                    try {
                        $model->setData( array( 'email' => $contact_form_data['customer_email'], 'message' => $contact_form_data['message'] ) );
                        $model->setCreatedTime(now());
                        $model->save();
                    } catch (Exception $e) {
                        Mage::log(json_encode($post), null, 'contactus.log');
                        Mage::log($e->getMessage(), null, 'contactus.log');
                    }
                }

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    Mage::log('Form data Error', null, 'contactus.log');
                    throw new Exception();
                }
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        explode(',', Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT)),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    Mage::log('Form Sent not Success', null, 'contactus.log');
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                
                Mage::log($e->getMessage(), null, 'contactus.log');
                
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }
    public function postenquiryAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $model = Mage::getModel('contactsus/contactsus');
				if (isset($post['main_contact_e'])) {
					$post['email'] 			= $post['main_contact_e'];
					if (@isset($post['customer_email'])) {
						$post['customer_email'] 	= $post['main_contact_e'];
					}
				}
				
				$postObject = new Varien_Object();
				$postObject->setData($post);
                
                $contact_form_data = $model->setDataTemplateForStoring($post);
                
                $isSaveEnabled = Mage::getStoreConfig('contactsus/general/enable_save');
                
                if($isSaveEnabled){
                    try {
                        $model->setData( array( 'email' => $contact_form_data['customer_email'], 'message' => $contact_form_data['message'] ) );
                        $model->setCreatedTime(now());
                        $model->save();
                    } catch (Exception $e) {
                        Mage::log(json_encode($post), null, 'contactus.log');
                        Mage::log($e->getMessage(), null, 'contactus.log');
                    }
                }

                $error = false;

                if (!Zend_Validate::is(trim($post['bridename']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['groomname']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['weddingdate']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['contactnumber']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }                
                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    Mage::log('Form data Error', null, 'enquiry_form.log');
                    throw new Exception();
                }
		
		if( !empty( trim($post['tempemail'])) ) {
			$templateId = $post['tempemail'];
		} else { 
			$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE); 
		}
		
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        $templateId,
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        explode(',', Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT)), 
                        null,
                        array('data' => $postObject)
                    );

 
                if (!$mailTemplate->getSentSuccess()) {
                    Mage::log('Form Sent not Success', null, 'contactus.log');
                    throw new Exception();
                }

                $translate->setTranslateInline(true);
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                
                //session_write_close(); 
                /*$this->_redirect('weddings/wedding-cakes.html');*/
                header("Location: " . $_SERVER["HTTP_REFERER"]); exit;
               
                return;
            } catch (Exception $e) {
                
                Mage::log($e->getMessage(), null, 'contactus.log');
                
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                 header("Location: " . $_SERVER["HTTP_REFERER"]);
                return;
            }

        } else {
             header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function postenquiryurlAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $model = Mage::getModel('contactsus/contactsus');
                if (isset($post['main_contact_e'])) {
                    $post['email']          = $post['main_contact_e'];
                    if (@isset($post['customer_email'])) {
                        $post['customer_email']     = $post['main_contact_e'];
                    }
                }
                
                $postObject = new Varien_Object();
                $postObject->setData($post);
                
                $contact_form_data = $model->setDataTemplateForStoring($post);
                
                $isSaveEnabled = Mage::getStoreConfig('contactsus/general/enable_save');
                
                if($isSaveEnabled){
                    try {
                        $model->setData( array( 'email' => $contact_form_data['customer_email'], 'message' => $contact_form_data['message'] ) );
                        $model->setCreatedTime(now());
                        $model->save();
                    } catch (Exception $e) {
                        Mage::log(json_encode($post), null, 'contactus.log');
                        Mage::log($e->getMessage(), null, 'contactus.log');
                    }
                }

                $error = false;

                if (!Zend_Validate::is(trim($post['bridename']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['groomname']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['weddingdate']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['contactnumber']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }                
                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    Mage::log('Form data Error: one of the field was empty', null, 'enquiry_form.log');
                    throw new Exception();
                }

                $bride = trim($post['bridename']);
                $groom = trim($post['groomname']);
        
                if( !empty( trim($post['tempemail'])) ) {
                    $templateId = $post['tempemail'];
                } else { 
                    $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE); 
                }
        
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        $templateId,
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        explode(',', Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT)), 
                        null,
                        array('data' => $postObject)
                    );

 
                if (!$mailTemplate->getSentSuccess()) {
                    Mage::log('Trying to sent email Template was not Success', null, 'contactus.log');
                    throw new Exception();
                }

                $translate->setTranslateInline(true);
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                
                header("Location: " . $_SERVER["HTTP_REFERER"]. '?sent=success&bride='.$bride.'&groom='.$groom ); exit;
               
                return;
            } catch (Exception $e) {
                
                Mage::log($e->getMessage(), null, 'contactus.log');
                
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                 header("Location: " . $_SERVER["HTTP_REFERER"]. '?sent=fail' );
                return;
            }

        } else {
             header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function postenquirypartyclassesAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
				
				if (isset($post['main_contact_e'])) {
					$post['email'] 			= $post['main_contact_e'];
					if (@isset($post['customer_email'])) {
						$post['customer_email'] 	= $post['main_contact_e'];
					}
				}
				
                $postObject = new Varien_Object();
                $postObject->setData($post);
                                
                $model = Mage::getModel('contactsus/contactsus');
                
                $contact_form_data = $model->setDataTemplateForStoring($post);
                
                $isSaveEnabled = Mage::getStoreConfig('contactsus/general/enable_save');
                
                if($isSaveEnabled){
                    try {
                        $model->setData( array( 'email' => $contact_form_data['customer_email'], 'message' => $contact_form_data['message'] ) );
                        $model->setCreatedTime(now());
                        $model->save();
                    } catch (Exception $e) {
                        Mage::log(json_encode($post), null, 'contactus.log');
                        Mage::log($e->getMessage(), null, 'contactus.log');
                    }
                }

                $error = false;

                if (!Zend_Validate::is(trim($post['yourname']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['yourphone']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['email']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['preferreddate']) , 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }
                
                if ($error) {
                    Mage::log('Form data Error', null, 'contactus.log');
                    throw new Exception();
                }
        
                if( !empty( trim($post['tempemail'])) ) {
                    $templateId = $post['tempemail'];
                } else { 
                    $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE); 
                }
        
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        $templateId,
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        explode(',', Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT)), 
                        null,
                        array('data' => $postObject)
                    );

 
                if (!$mailTemplate->getSentSuccess()) {
                    Mage::log('Email sending not Success', null, 'contactus.log');
                    throw new Exception();
                }

                $translate->setTranslateInline(true);
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('contacts')->__('Your enquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                
                //session_write_close(); 
                /*$this->_redirect('weddings/wedding-cakes.html');*/
                header("Location: " . $_SERVER["HTTP_REFERER"]); exit;
                
                return;

            } catch (Exception $e) {
                
                Mage::log($e->getMessage(), null, 'contactus.log');
                
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                 header("Location: " . $_SERVER["HTTP_REFERER"]);
                return;
            }

        } else {
             header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

}


<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

class Anlprz_Contactsus_Block_Adminhtml_Contactsus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('contactsusGrid');
      $this->setDefaultSort('contactemails_id');
      $this->setDefaultDir('DSC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('contactsus/contactsus')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('contactemails_id', array(
          'header'    => Mage::helper('contactsus')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'contactemails_id',
      ));

      $this->addColumn('email', array(
          'header'    => Mage::helper('contactsus')->__('email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
      $this->addColumn('message', array(
          'header'    => Mage::helper('contactsus')->__('Message'),
          'align'     =>'left',
          'index'     => 'message',
      ));
            
      $this->addColumn('created_time', array(
          'header'    => Mage::helper('contactsus')->__('Time Created'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
	  
      $this->addColumn('action',
          array(
                'header'    =>  Mage::helper('contactsus')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('contactsus')->__('View'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('contactsus')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('contactsus')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('contactsus_id');
        $this->getMassactionBlock()->setFormFieldName('contactsus');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('contactsus')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('contactsus')->__('Are you sure?')
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
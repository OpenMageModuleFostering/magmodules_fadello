<?php 
/**
 * Magmodules.eu - http://www.magmodules.eu
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magmodules.eu so we can send you a copy immediately.
 *
 * @category	Magmodules
 * @package		Magmodules_Fadello
 * @author		Magmodules <info@magmodules.eu)
 * @copyright	Copyright (c) 2016 (http://www.magmodules.eu)
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Magmodules_Fadello_Block_Adminhtml_Config_Form_Field_Shipping extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {

	protected $_renders = array();

	public function __construct()
    {                
        $this->addColumn('from', array(
            'label' => Mage::helper('fadello')->__('From Price'),
            'style' => 'width:50px',           
        ));
        
        $this->addColumn('to', array(
            'label' => Mage::helper('fadello')->__('To Price'),
            'style' => 'width:50px',            
        ));
        
        $this->addColumn('cost', array(
            'label' => Mage::helper('fadello')->__('Cost'),
            'style' => 'width:50px',           
        ));        
                                
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('fadello')->__('Add Option');
        parent::__construct();
    }

	protected function _prepareArrayRow(Varien_Object $row)
    {    	
    	foreach ($this->_renders as $key => $render){
	        $row->setData(
	            'option_extra_attr_' . $render->calcOptionHash($row->getData($key)),
	            'selected="selected"'
	        );
    	}
    } 

}
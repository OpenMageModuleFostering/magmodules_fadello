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
 
class Magmodules_Fadello_Model_Observer {

    public function addDataToOrderGrid($observer)
    {
        $block = $observer->getEvent()->getBlock();
        if($block->getType() == 'adminhtml/sales_order_grid') {
			if(Mage::getStoreConfig('shipping/fadello/enabled')) {
				$block->addColumnAfter('fadello', array(
					'header'    => 'Fadello',
					'type'      => 'text',
					'index'     => 'fadello',
					'filter'    => false,
					'sortable'  => false,  
					'renderer'	=> 'Magmodules_Fadello_Block_Adminhtml_Renderer_Shipment',
					'width'		=> '120px',
				), 'status');
			}
        }        
    }  

	public function salesOrderGridCollectionLoadBefore($observer)
	{
		if(Mage::getStoreConfig('shipping/fadello/enabled')) {
			if(Mage::helper('core')->isModuleEnabled('TIG_PostNL')) {
	        	if(Mage::helper('postnl')->isEnabled()) {
	        		return;
	        	}
			}
			$collection = $observer->getOrderGridCollection();
			$select = $collection->getSelect();
			$select->join('sales_flat_order', 'main_table.entity_id = sales_flat_order.entity_id', array('shipping_method'));
			$select->group('main_table.entity_id');
		}
	}

}
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

class Magmodules_Fadello_Block_Adminhtml_Renderer_Shipment extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

	public function render(Varien_Object $row) 
	{
		$html = '';
		$orderId = $row->getEntityId();	
		$status = $row->getFadelloStatus();
		$show_all_shipments = Mage::getStoreConfig('shipping/fadello/show_all_shipments');	
		if(!$show_all_shipments) {
			if($row->getShippingMethod() != 'fadello_fadello') {
				return $html;
			}
		}
		if(!empty($status)) {
			if($status == 'created') {
				$html .= '<a href="' . $this->getUrl('*/fadello/cancelShipment', array('order_id' => $orderId)) . '"><img title="' . $this->__('Cancel this Fadello Shipment') . '" src="' . $this->getSkinUrl('images/fadello/close.png' ) . '"></a>';
				$html .= '&nbsp; ';
				$html .= '<a href="' . $this->getUrl('*/fadello/getPdf', array('order_id' => $orderId)) . '"><img title="' . $this->__('Open PDF') . '" src="' . $this->getSkinUrl('images/fadello/pdf.png') . '"></a>';
				$html .= '&nbsp; ';
				$html .= '<a href="' . $this->getUrl('*/fadello/shipOrder', array('order_id' => $orderId)) . '"><img title="' . $this->__('Ship This Order') . '" src="' . $this->getSkinUrl('images/fadello/export.png') . '"></a>';
			}
			if($status == 'shipped') {
				$html .= '<a href="' . $this->getUrl('*/fadello/cancelShipment', array('order_id' => $orderId, 'magento' => 1)) . '"><img title="' . $this->__('Cancel this Fadello Shipment') . '"  src="' . $this->getSkinUrl('images/rule_component_remove.gif') . '"></a>';
				$html .= '&nbsp; ';
				$html .= '<a href="' . $this->getUrl('*/fadello/getPdf', array('order_id' => $orderId)) . '"><img title="' . $this->__('Open PDF') . '" src="' . $this->getSkinUrl('images/fadello/pdf.png') . '"></a>';
			}
		} else {
			$html .= '<a href="' . $this->getUrl('*/fadello/createShipment', array('order_id' => $orderId)) . '"><img title="' . $this->__('Create Shipment') . '" src="' . $this->getSkinUrl('images/fadello/ship.png') . '"></a>';
		}	
		return $html;
	}

}
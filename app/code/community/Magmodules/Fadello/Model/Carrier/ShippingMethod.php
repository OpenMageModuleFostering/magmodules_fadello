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
 
class Magmodules_Fadello_Model_Carrier_ShippingMethod extends Mage_Shipping_Model_Carrier_Abstract {

	protected $_code = 'fadello';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request) 
    {

        if(!$this->getConfigFlag('active')) {
            return false;
        }

        if(!Mage::getStoreConfig('shipping/fadello/enabled')) {
            return false;
        }
        
		if($max_weight = Mage::getStoreConfig('carriers/fadello/weight')) {
			if($request->getPackageWeight() > $max_weight) {
				return false;
			}
		}

		$active = Mage::helper('fadello')->isActive();
		if(!$active) {
			return false;
		}        
		
		$postcode = $request->getDestPostcode(); 
		if(!empty($postcode)) {
			$postcode_check = Mage::helper('fadello')->checkPostcode($request->getDestPostcode());
			if(!$postcode_check) {
				return false;
			}
		}
        
		$prices = @unserialize($this->getConfigData('shipping_price'));
		$total = $request->getBaseSubtotalInclTax();
		$shipping_cost = '0.00';
		
		foreach($prices as $shipping_price) {
			if(($total >= $shipping_price['from']) && ($total <= $shipping_price['to'])) {
				$shipping_cost = $shipping_price['cost'];
			}				
		}
		
        $result = Mage::getModel('shipping/rate_result');       
        $method = Mage::getModel('shipping/rate_result_method');
		$name = Mage::getStoreConfig('carriers/fadello/name');
		
		$method->setCarrier('fadello');
		$method->setCarrierTitle($name);
		$method->setMethod('fadello');
		$method->setMethodTitle($active['title']);
		$method->setPrice($shipping_cost);
		$method->setCost('0.00');
		$result->append($method);
        return $result;
    }
 
    public function getAllowedMethods() 
    {
        return array($this->_code => $this->getConfigData('name'));
    }
 
}
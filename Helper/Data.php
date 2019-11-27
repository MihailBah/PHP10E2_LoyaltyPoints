<?php

namespace PHP10E2\LoyaltyPoints\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getConfig($scope)
    {
        try {
            switch($scope){
                case 'store':
                    return $this->scopeConfig->getValue('LoyaltyPoints/general/value', ScopeInterface::SCOPE_STORE);
                case 'website':
                    return $this->scopeConfig->getValue('LoyaltyPoints/general/value', ScopeInterface::SCOPE_WEBSITE);
                default:
                    return $this->scopeConfig->getValue('LoyaltyPoints/general/value', ScopeInterface::SCOPE_STORE);
            }

        } catch (\Exception $e) {
            return false;
        }
    }
}
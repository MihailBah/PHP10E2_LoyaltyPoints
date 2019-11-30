<?php

namespace PHP10E2\LoyaltyPoints\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use PHP10E2\LoyaltyPoints\Block\System\Config;

class Data extends AbstractHelper
{
    public function getConfig($scope)
    {
        try {
            switch ($scope) {
                case 'store':
                    $scopeType = ScopeInterface::SCOPE_STORE;
                    break;
                case 'website':
                    $scopeType = ScopeInterface::SCOPE_WEBSITE;
                    break;
                default:
                    $scopeType = ScopeInterface::SCOPE_STORE;
            }

            return $this->scopeConfig->getValue(Config::CONFIG_PATH_LOYALTYPOINTS_GENERAL_VALUE, $scopeType);
        } catch (\Exception $e) {
            return false;
        }
    }
}

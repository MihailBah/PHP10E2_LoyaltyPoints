<?php

namespace PHP10E2\LoyaltyPoints\Block\System;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * @package PHP10E2\LoyaltyPoints\Block\System
 */
class Config extends Template
{
    const CONFIG_PATH_LOYALTYPOINTS_GENERAL_VALUE = 'LoyaltyPoints/general/value';
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param Context              $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array                $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string|null $storeId
     *
     * @return mixed
     */
    public function getCustomConfig(?string $storeId = null)
    {
        return $this->scopeConfig->getValue(
            'LoyaltyPoints/general/value',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}

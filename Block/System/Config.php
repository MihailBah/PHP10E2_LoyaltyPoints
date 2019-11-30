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
    protected static $scopeConfig;

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
        self::$scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public static function getCustomConfig()
    {
        return self::$scopeConfig->getValue(
            self::CONFIG_PATH_LOYALTYPOINTS_GENERAL_VALUE,
            ScopeInterface::SCOPE_STORE
        );
    }
}

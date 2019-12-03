<?php

namespace PHP10E2\LoyaltyPoints\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class CustomerLoyaltyPoints extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'customer_entity';

    protected $_cacheTag = 'customer_entity';

    protected $_eventPrefix = 'customer_entity';

    protected function _construct()
    {
        $this->_init('PHP10E2\LoyaltyPoints\Model\ResourceModel\CustomerLoyaltyPoints');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        return [];
    }
}

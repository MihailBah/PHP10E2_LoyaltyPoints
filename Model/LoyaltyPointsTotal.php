<?php

namespace PHP10E2\LoyaltyPoints\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class LoyaltyPointsTotal extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'sales_order';

    protected $_cacheTag = 'sales_order';

    protected $_eventPrefix = 'sales_order';

    protected function _construct()
    {
        $this->_init('PHP10E2\LoyaltyPoints\Model\ResourceModel\LoyaltyPointsTotal');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}

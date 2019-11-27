<?php

namespace PHP10E2\LoyaltyPoints\Model;

class TodoItem extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'customer_entity';

    protected $_cacheTag = 'customer_entity';

    protected $_eventPrefix = 'customer_entity';

    protected function _construct()
    {
        $this->_init('PHP10E2\LoyaltyPoints\Model\ResourceModel\TodoItem');
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
<?php

namespace PHP10E2\LoyaltyPoints\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class TodoItem extends AbstractDb // TODO rename to LoyaltyPoints
{
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('customer_entity', 'entity_id'); // TODO mainTable maybe change to const from Model
    }
}

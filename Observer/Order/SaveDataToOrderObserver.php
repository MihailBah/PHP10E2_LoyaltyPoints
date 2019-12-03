<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Model\Quote\LoyaltyPointsTotal;

class SaveDataToOrderObserver implements ObserverInterface
{

    /**
     * @inheritDoc
     */
    public function execute(EventObserver $observer)
    {
//        $points = LoyaltyPointsTotal::getDebPoints();
        $order = $observer->getOrder();
//        $order->setCustomerPrefix('TEST DATA');
//        return $this;
    }
}
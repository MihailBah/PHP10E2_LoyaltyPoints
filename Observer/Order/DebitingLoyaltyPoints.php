<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory;
use PHP10E2\LoyaltyPoints\Model\Quote\LoyaltyPointsTotal;

class DebitingLoyaltyPoints implements ObserverInterface
{
    /**
     * @var Info
     */
    public $blockInfo;

    public $toDoFactory;

    public $lpTotal;

    /**
     * Data constructor.
     * @param Info $blockInfo
     * @param TodoItemFactory $toDoFactory
     * @param LoyaltyPointsTotal $lpTotal
     */
    public function __construct(
        Info $blockInfo,
        TodoItemFactory $toDoFactory,
        LoyaltyPointsTotal $lpTotal
    )
    {
        $this->blockInfo = $blockInfo;
        $this->toDoFactory = $toDoFactory;
        $this->lpTotal = $lpTotal;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);

        $todo = $this->toDoFactory->create();
        $id = $this->blockInfo->getCustomerId();
        $todo = $todo->load($id);

        $oldLP = intval($todo->getData('loyalty_points'));

        $debitedPoints = LoyaltyPointsTotal::$debitedPoints;

        $result = $oldLP - $debitedPoints;

        $todo->setData('loyalty_points', $result)->save();
    }
}
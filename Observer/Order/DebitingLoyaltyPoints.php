<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory;

class DebitingLoyaltyPoints implements ObserverInterface
{
    /**
     * @var Info
     */
    public $blockInfo;

    public $toDoFactory;

    /**
     * Data constructor.
     * @param Info $blockInfo
     * @param TodoItemFactory $toDoFactory
     */
    public function __construct(
        Info $blockInfo,
        TodoItemFactory $toDoFactory
    )
    {
        $this->blockInfo = $blockInfo;
        $this->toDoFactory = $toDoFactory;
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

        $subtotal = $order->getSubtotal();

        $result = $subtotal - $oldLP;

        if ($result >= 0) {
            $todo->setData('loyalty_points', 0)->save();
        } else {
            $result = $result * -1;
            $todo->setData('loyalty_points', $result)->save();
        }
    }
}
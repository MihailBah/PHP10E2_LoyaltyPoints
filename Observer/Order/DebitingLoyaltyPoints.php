<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Exception;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote\Address\Total;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Model\Quote\LoyaltyPointsTotal;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory; // TODO \LoyaltyPointsFactory

/**
 * Class DebitingLoyaltyPoints
 * @package PHP10E2\LoyaltyPoints\Observer\Order
 */
class DebitingLoyaltyPoints implements ObserverInterface
{
    /**
     * @var Info
     */
    public $blockInfo;

    public $toDoFactory;

//    public $total;

    /**
     * Data constructor.
     * @param Info $blockInfo
     * @param TodoItemFactory $toDoFactory
     */
    public function __construct(
        Info $blockInfo,
        TodoItemFactory $toDoFactory
//        Total $total
    ) {
        $this->blockInfo = $blockInfo;
        $this->toDoFactory = $toDoFactory;
//        $this->total = $total;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();

        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);

        $todo = $this->toDoFactory->create(); // TODO rename loyaltyPointModel
        $id = $this->blockInfo->getCustomerId();
        $todo = $todo->load($id);

        $oldLP = intval($todo->getData('loyalty_points'));

        $subtotal = $order->getSubtotal();

        //$discount = $order->getDiscountAmount();

        //$grandTotal = $order->getGrandTotal();

        //$result = $grandTotal - $oldLP;
        $am = LoyaltyPointsTotal::getDebPoints();
        $bAm = LoyaltyPointsTotal::getDebBasePoints();

        $result = $subtotal - $oldLP;

        if ($result >= 0) {
            $todo->setData('loyalty_points', 0)->save();
        } else {
            $result = $result * -1;
            $todo->setData('loyalty_points', $result)->save();
        }
    }
}

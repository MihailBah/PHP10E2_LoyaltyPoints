<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Exception;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote\Address\Total;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Model\Quote\LoyaltyPointsTotal;
use PHP10E2\LoyaltyPoints\Model\CustomerLoyaltyPointsFactory;

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

    public $customerLoyaltyPointsFactory;

//    public $total;

    /**
     * Data constructor.
     * @param Info $blockInfo
     * @param CustomerLoyaltyPointsFactory $customerLoyaltyPointsFactory
     */
    public function __construct(
        Info $blockInfo,
        CustomerLoyaltyPointsFactory $customerLoyaltyPointsFactory
//        Total $total
    ) {
        $this->blockInfo = $blockInfo;
        $this->customerLoyaltyPointsFactory = $customerLoyaltyPointsFactory;
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

        $loyaltyPointsModel = $this->customerLoyaltyPointsFactory->create();
        $id = $this->blockInfo->getCustomerId();
        $loyaltyPointsModel = $loyaltyPointsModel->load($id);

        $oldLP = floatval($loyaltyPointsModel->getData('loyalty_points'));

        //$subtotal = $order->getSubtotal();

        //$discount = $order->getDiscountAmount();

        //$grandTotal = $order->getGrandTotal();

        //$result = $grandTotal - $oldLP;
        $am = LoyaltyPointsTotal::getDebPoints();
        $bAm = LoyaltyPointsTotal::getDebBasePoints();

//        $result = $subtotal - $oldLP;
//
//        if ($result >= 0) {
//            $loyaltyPointsModel->setData('loyalty_points', 0)->save();
//        } else {
//            $result = $result * -1;
//            $loyaltyPointsModel->setData('loyalty_points', $result)->save();
//        }
    }
}

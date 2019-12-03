<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;
use PHP10E2\LoyaltyPoints\Model\CustomerLoyaltyPointsFactory;

/**
 * Class AccrualLoyaltyPoints
 * @package PHP10E2\LoyaltyPoints\Observer\Order
 */
class AccrualLoyaltyPoints implements ObserverInterface
{
    /**
     * @var Get
     */
    public $get;

    /**
     * @var Info
     */
    public $blockInfo;

    protected $scopeConfig;

    protected $customerLoyaltyPointsFactory;

    /**
     * Data constructor.
     * @param Get $get
     * @param Info $blockInfo
     * @param ScopeConfigInterface $scopeConfig
     * @param CustomerLoyaltyPointsFactory $customerLoyaltyPointsFactory
     */
    public function __construct(
        Get $get,
        Info $blockInfo,
        ScopeConfigInterface $scopeConfig,
        CustomerLoyaltyPointsFactory $customerLoyaltyPointsFactory
    ) {
        $this->get = $get;
        $this->blockInfo = $blockInfo;
        $this->scopeConfig = $scopeConfig;
        $this->customerLoyaltyPointsFactory = $customerLoyaltyPointsFactory;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();

        $encodedId = $this->get->getFromCookie();
        if (!empty($encodedId)) {
            $decodedId= $this->blockInfo->decryptData($encodedId, $this->blockInfo::KEY);

            $id = $this->blockInfo->getCustomerId();

            if ($decodedId != $id) {
                $objectManager = ObjectManager::getInstance();
                $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);

                $grandTotal = $order->getGrandTotal();

                $percentage = $this->blockInfo->getDataFromAdmin();
                $LP = round(($percentage / 100) * $grandTotal, 2);

                $loyaltyPointModel = $this->customerLoyaltyPointsFactory->create();
                $loyaltyPointModel = $loyaltyPointModel->load($decodedId);

                $oldLP = floatval($loyaltyPointModel->getData('loyalty_points'));
                $newLP = $oldLP + $LP;
                $loyaltyPointModel->setData('loyalty_points', $newLP)->save();
            }
        }
    }
}

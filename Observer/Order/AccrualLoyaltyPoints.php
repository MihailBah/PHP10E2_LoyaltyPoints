<?php

namespace PHP10E2\LoyaltyPoints\Observer\Order;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory;

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

    protected $toDoFactory;

    /**
     * Data constructor.
     * @param Get $get
     * @param Info $blockInfo
     * @param ScopeConfigInterface $scopeConfig
     * @param TodoItemFactory $toDoFactory
     */
    public function __construct(
        Get $get,
        Info $blockInfo,
        ScopeConfigInterface $scopeConfig,
        TodoItemFactory $toDoFactory
    )
    {
        $this->get = $get;
        $this->blockInfo = $blockInfo;
        $this->scopeConfig = $scopeConfig;
        $this->toDoFactory = $toDoFactory;
    }

    /**
     * @param Observer $observer
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();

        $encodedId = $this->get->getFromCookie();
        $decodedId= $this->blockInfo->decryptData($encodedId, 'key');

        $id = $this->blockInfo->getCustomerId();

        if ($decodedId != $id) {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);

            $grandTotal = $order->getGrandTotal();

            $percentage = $this->blockInfo->getDataFromAdmin();
            $LP = round(($percentage / 100) * $grandTotal);

            $todo = $this->toDoFactory->create();
            $todo = $todo->load($decodedId);

            $oldLP = intval($todo->getData('loyalty_points'));
            $newLP = $oldLP + $LP;
            $todo->setData('loyalty_points', $newLP)->save();
        }
    }
}

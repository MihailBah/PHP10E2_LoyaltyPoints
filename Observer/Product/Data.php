<?php

namespace PHP10E2\LoyaltyPoints\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use PHP10E2\LoyaltyPoints\Block\Info;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;

class Data implements ObserverInterface
{
    /**
     * @var Get
     */
    public $get;

    /**
     * @var Info
     */
    public $blockInfo;

    /**
     * Data constructor.
     * @param Get $get
     * @param Info $blockInfo
     */
    public function __construct(Get $get, Info $blockInfo)
    {
        $this->get = $get;
        $this->blockInfo = $blockInfo;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        $encodedId = $this->get->getFromCookie();
        $decodedId= $this->blockInfo->decryptData($encodedId, 'key');

        print_r("Catch event successfully : " . $decodedId);

        //exit;
    }
}

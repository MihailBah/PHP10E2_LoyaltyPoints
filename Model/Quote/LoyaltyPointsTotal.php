<?php

namespace PHP10E2\LoyaltyPoints\Model\Quote;

use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use PHP10E2\LoyaltyPoints\Block\Info;

class LoyaltyPointsTotal extends AbstractTotal
{
    /**
     * @var Info
     */
    public $blockInfo;

    /**
     * @const string
     */
    const CODE = 'loyalty_points_total';

    public function __construct(Info $blockInfo)
    {
        $this->setCode(self::CODE);
        $this->blockInfo = $blockInfo;
    }

    public function getAmount()
    {
        return $this->blockInfo->getLoyaltyPoints();
    }

    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        $allTotalAmounts = array_sum($total->getAllTotalAmounts());
        $allBaseTotalAmounts = array_sum($total->getAllBaseTotalAmounts());
        $amount = $this->getAmount();
        $totalSale = $amount > $allTotalAmounts ? $allTotalAmounts : $amount;
        $totalBaseSale = $amount > $allBaseTotalAmounts ? $allBaseTotalAmounts : $amount;

        $total->addTotalAmount($this->getCode(), -$totalSale);
        $total->addBaseTotalAmount($this->getCode(), -$totalBaseSale);
    }

    public function fetch(
        Quote $quote,
        Total $total
    ) {
        return [
            'code' => $this->getCode(),
            'title' => __('Loyalty points'),
            'value' => $this->getAmount(),
        ];
    }
}

<?php

namespace PHP10E2\LoyaltyPoints\Model\Quote;

use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use PHP10E2\LoyaltyPoints\Block\Info;

/**
 * Class LoyaltyPointsTotal
 * @package PHP10E2\LoyaltyPoints\Model\Quote
 */
class LoyaltyPointsTotal extends AbstractTotal
{
    /**
     * @var Info
     */
    public $blockInfo;

    /**
     * @var bool
     */
    private $usePoints = true;

    /**
     * @var float
     */
    private static $debPoints;

    /**
     * @var float
     */
    private static $debBasePoints;

    /**
     * @const string
     */
    const CODE = 'loyalty_points_total';

    const BASE_CODE = 'loyalty_points_base_total';

    /**
     * LoyaltyPointsTotal constructor.
     * @param Info $blockInfo
     */
    public function __construct(Info $blockInfo)
    {
        $this->setCode(self::CODE);
        $this->blockInfo = $blockInfo;
    }

    /**
     * @return float|null
     */
    public function getAmount() : ?float
    {
        return $this->blockInfo->getLoyaltyPoints();
    }

    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        if ($this->usePoints) {
            $allTotalAmounts = array_sum($total->getAllTotalAmounts());
            $allBaseTotalAmounts = array_sum($total->getAllBaseTotalAmounts());

            $amount = $this->getAmount();

            $totalSale = $amount > $allTotalAmounts ? $allTotalAmounts : $amount;
            $totalBaseSale = $amount > $allBaseTotalAmounts ? $allBaseTotalAmounts : $amount;

            self::$debPoints = $totalSale;
            self::$debBasePoints = $totalBaseSale;

            $total->addTotalAmount($this->getCode(), -$totalSale);
            $total->addBaseTotalAmount($this->getCode(), -$totalBaseSale);
        }
    }

    public function fetch(
        Quote $quote,
        Total $total
    ) {
        return [
            'code' => $this->getCode(),
            'title' => __('Loyalty points'),
            'value' => $this->getDebPoints()
        ];
    }

    /**
     * @return void
     */
    public function changeUsePoints() : void
    {
        $this->usePoints ? $this->usePoints = false : $this->usePoints = true;
    }

    /**
     * @return bool
     */
    public function getUsePoints() : bool
    {
        return $this->usePoints;
    }

    /**
     * @return float|null
     */
    public static function getDebPoints() : ?float
    {
        return -self::$debPoints;
    }

    /**
     * @return float|null
     */
    public static function getDebBasePoints() : ?float
    {
        return -self::$debBasePoints;
    }
}

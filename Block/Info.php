<?php
namespace PHP10E2\LoyaltyPoints\Block;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Info
 * @package PHP10E2\LoyaltyPoints\Block
 */
class Info extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;

    /**
     * Info constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ) {

        $this->_customerSession = $customerSession;
        parent::__construct($context, []);
    }

    public function getCustomerEmail()
    {
        return $this->_customerSession->getCustomer() ? $this->_customerSession->getCustomer()->getEmail() : '';
    }
}

<?php
namespace PHP10E2\LoyaltyPoints\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use PHP10E2\LoyaltyPoints\Block\System\Config;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory; // TODO \LoyaltyPointsFactory

/**
 * Class Info
 * @package PHP10E2\LoyaltyPoints\Block
 */
// TODO maybe rename to CustomerLoyaltyPoints
class Info extends \Magento\Framework\View\Element\Template
{
    /**
     *  const string
     */
    const KEY = 'key';

    /**
     *  const string
     */
    const PATH_TO_GET_CONTROLLER = 'php10e2_loyaltypoints/referral/get/';

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var TodoItemFactory
     */
    private $toDoFactory;

//    /**
//     * @var
//     */
//    private $_objectManager;

    /**
     * Info constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param TodoItemFactory $toDoFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        TodoItemFactory $toDoFactory
    ) {
        $this->customerSession = $customerSession;
        $this->toDoFactory = $toDoFactory;
        parent::__construct($context, []);
    }

    /**
     * @return string
     */
    public function getCustomerEmail() : string
    {
        return $this->customerSession->getCustomer() ? $this->customerSession->getCustomer()->getEmail() : '';
    }

    /**
     * @return string
     */
    public function getReferralLink() : string
    {
        return $this->getBaseUrl() . self::PATH_TO_GET_CONTROLLER . Get::COOKIE_REFERRAL . '/' . $this->encryptId();
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomer() ? $this->customerSession->getCustomer()->getId() : '';
    }

    public function encryptData($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('cast5-cfb'));
        $encrypted = openssl_encrypt($data, 'cast5-cfb', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decryptData($data, $key)
    {
        list($data, $iv) = explode('::', base64_decode($data));
        return openssl_decrypt($data, 'cast5-cfb', $key, 0, $iv);
    }

    public function encryptId()
    {
        return $this->encryptData($this->getCustomerId(), self::KEY);
    }

    /**
     * @return float|null
     */
    public function getLoyaltyPoints() : ?float
    {
        $todo = $this->toDoFactory->create();
        $id = $this->getCustomerId();
        $todo = $todo->load($id);
        return $todo->getData('loyalty_points');
    }

    /**
     * @return int
     */
    public function getDataFromAdmin() : int
    {
        return $this->_scopeConfig->getValue(Config::CONFIG_PATH_LOYALTYPOINTS_GENERAL_VALUE, ScopeInterface::SCOPE_STORE);
    }
}

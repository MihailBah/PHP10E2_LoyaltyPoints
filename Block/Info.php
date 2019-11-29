<?php
namespace PHP10E2\LoyaltyPoints\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use PHP10E2\LoyaltyPoints\Block\System\Config;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;
use PHP10E2\LoyaltyPoints\Model\TodoItemFactory; // TODO \LoyaltyPointsFactory

/**
 * Class Info
 * @package PHP10E2\LoyaltyPoints\Block
 */
class Info extends \Magento\Framework\View\Element\Template // TODO maybe rename to CustomerLoyaltyPoints
{
    /**
     *  const string
     */
    const KEY = 'key';

    /**
     *  const string
     */
    const PATH_TO_GET_CONTROLLER = 'php10e2_loyaltypoints/referral/get/';

    protected $_customerSession;

    protected $toDoFactory;

    protected $_objectManager;

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
        $this->_customerSession = $customerSession;
        $this->toDoFactory = $toDoFactory;
        parent::__construct($context, []);
    }

    public function getCustomerEmail()
    {
        return $this->_customerSession->getCustomer() ? $this->_customerSession->getCustomer()->getEmail() : '';
    }

    public function getReferralLink()
    {
        $referralLink = $this->getBaseUrl() . self::PATH_TO_GET_CONTROLLER . Get::COOKIE_REFERRAL . '/' . $this->encryptId();
        return $referralLink;
    }

    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer() ? $this->_customerSession->getCustomer()->getId() : '';
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

    public function getLoyaltyPoints()
    {
        $todo = $this->toDoFactory->create();
        $id = $this->getCustomerId();
        $todo = $todo->load($id);
        return $todo->getData('loyalty_points');
    }

    public function getDataFromAdmin()
    {
        return Config::getCustomConfig();
//        return $this->_scopeConfig->getValue('LoyaltyPoints/general/value', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}

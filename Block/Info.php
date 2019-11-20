<?php
namespace PHP10E2\LoyaltyPoints\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Customer\Model\Session;
use PHP10E2\LoyaltyPoints\Controller\Referral\Get;
//use Magento\Framework\Session\SessionManager;

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

    public function getReferralLink()
    {
        $referralLink = $this->getBaseUrl() . 'php10e2_loyaltypoints/referral/get/referral/' . $this->encryptId();
        return $referralLink;
    }

    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer() ? $this->_customerSession->getCustomer()->getId() : '';
    }

    function encryptData($data, $key) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('cast5-cfb'));
        $encrypted = openssl_encrypt($data, 'cast5-cfb', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    function decryptData($data, $key) {
        list($data, $iv) = explode('::', base64_decode($data));
        return openssl_decrypt($data, 'cast5-cfb', $key, 0, $iv);
    }

    function encryptId()
    {
        return $this->encryptData($this->getCustomerId(), 'key');
    }

    function decryptId()
    {
        return $this->decryptData($this->encryptId(), 'key');
    }
}

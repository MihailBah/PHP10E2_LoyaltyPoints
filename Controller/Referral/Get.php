<?php

namespace PHP10E2\LoyaltyPoints\Controller\Referral;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException;
use Magento\Framework\Stdlib\Cookie\FailureToSendException as FailureToSendExceptionAlias;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\Framework\View\Element\Template;

/**
 * Class Get
 * @package PHP10E2\LoyaltyPoints\Controller\Referral
 */
class Get extends Action
{
    /**
     * @const string
     */
    const COOKIE_REFERRAL = 'referral';

    /**
     * @const int
     */
    const LIFE_TIME_COOKIE = 86400; // 86400 seconds = 1 day;

    /**
     * @var PhpCookieManager
     */
    private $cookieManager;

    /**
     * @var Template
     */
    private $template;

    /**
     * Get constructor.
     * @param Context $context
     * @param PhpCookieManager $cookieManager
     * @param Template $template
     */
    public function __construct(Context $context, PhpCookieManager $cookieManager, Template $template)
    {
        $this->template = $template;
        $this->cookieManager = $cookieManager;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     * @throws CookieSizeLimitReachedException
     * @throws FailureToSendExceptionAlias
     * @throws InputException
     */
    public function execute()
    {
        $value = $this->getRequest()->getParam(self::COOKIE_REFERRAL);

        $meta = new PublicCookieMetadata();
        $meta->setPath('/');
        $meta->setDuration(self::LIFE_TIME_COOKIE * 30); // 1 month
        $this->cookieManager->setPublicCookie(self::COOKIE_REFERRAL, $value, $meta);
        $this->_redirect($this->template->getBaseUrl());
    }

    /**
     * @return string
     */
    public function getFromCookie() : ?string
    {
        return $this->cookieManager->getCookie(self::COOKIE_REFERRAL);
    }
}

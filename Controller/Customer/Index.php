<?php

namespace PHP10E2\LoyaltyPoints\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

/**
 * Class Index
 * @package PHP10E2\LoyaltyPoints\Controller\Customer
 */
class Index extends Action
{
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
//    public function execute()
//    {
//        $this->_view->loadLayout();
//        $this->_view->renderLayout();
//    }
}

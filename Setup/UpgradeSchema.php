<?php
namespace PHP10E2\LoyaltyPoints\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
//use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerTable = 'customer_entity';
        $orderTable = 'sales_order';

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($customerTable),
                'loyalty_points',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' =>'10000',
                    'nullable' => true,
                    'comment' =>'Loyalty Points'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'referral_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length'=>'10',
                    'nullable' => true,
                    'comment' =>'Referral ID'
                ]
            );

        $setup->endSetup();
    }
}
<?php

namespace PHP10E2\LoyaltyPoints\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('customer_entity'),
                'loyalty_points',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'nullable' => true,
                    'default' => 0,
                    'comment' =>'Loyalty Points'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('sales_order'),
                'loyalty_points_total',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'nullable' => true,
                    'default' => null,
                    'comment' =>'Loyalty Points Total'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('sales_order'),
                'loyalty_points_base_total',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'nullable' => true,
                    'default' => null,
                    'comment' =>'Loyalty Points Base Total'
                ]
            );
        }
        $installer->endSetup();
    }
}

<?php

namespace PHP10E2\LoyaltyPoints\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context ) {

        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.2.0', '<')) {

            $installer->getConnection()->addColumn(
                $installer->getTable('customer_entity'),
                'loyalty_points',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' =>'10000',
                    'nullable' => true,
                    'default' => 0,
                    'comment' =>'Loyalty Points'
                ]
            );
        }
        $installer->endSetup();
    }
}
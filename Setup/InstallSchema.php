<?php
namespace Icovn\CategoryCustomAttribute\Setup;

use \Magento\Framework\DB\Ddl\Table;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;

use Psr\Log\LoggerInterface;

class InstallSchema implements InstallSchemaInterface
{
    protected $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->logInline("installSchema Topica_CategoryCustomAttribute");

        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('test_magento')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('test_magento')
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Test ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Test Name'
                )
                ->setComment('Test Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
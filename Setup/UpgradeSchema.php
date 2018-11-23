<?php

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use Magento\Eav\Setup\EavSetupFactory;

use Psr\Log\LoggerInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    private $eavSetupFactory;
    protected $categorySetupFactory;
    protected $logger;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CategorySetupFactory $categorySetupFactory,
        LoggerInterface $logger
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->logger = $logger;
    }

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->info("upgradeSchema Icovn_CategoryCustomAttribute");

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.2') < 0) {
            $this->logger->info("upgradeSchema Icovn_CategoryCustomAttribute ...");
        }

        $setup->endSetup();
    }
}
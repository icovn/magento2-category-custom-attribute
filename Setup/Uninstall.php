<?php
namespace Icovn\CategoryCustomAttribute\Setup;

use Magento\Catalog\Model\Category;

use Magento\Framework\Setup\LoggerInterface;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use Magento\Eav\Setup\EavSetupFactory;

class Uninstall implements UninstallInterface
{

    protected $eavSetupFactory;
    protected $logger;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        LoggerInterface $logger
    ){
        $this->eavSetupFactory = $eavSetupFactory;
        $this->logger = $logger;
    }



    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        print("version: " . $context->getVersion());
        $this->logger->logInline("uninstall Icovn_CategoryCustomAttribute");

        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->removeAttribute(Category::ENTITY, 'attribute_id');

        $setup->endSetup();

    }
}
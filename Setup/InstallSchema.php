<?php
namespace Icovn\CategoryCustomAttribute\Setup;

use \Magento\Catalog\Setup\CategorySetupFactory;

use \Magento\Framework\DB\Ddl\Table;

use \Magento\Framework\Setup\LoggerInterface;
use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;

use \Magento\Eav\Setup\EavSetupFactory;

class InstallSchema implements InstallSchemaInterface
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

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->logInline("installSchema icovn_magento2-category-custom-attribute");

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $setup = $this->categorySetupFactory->create(['setup' => $setup]);

        $setup->addAttribute(Category::ENTITY, 'my_attribute', [
            'type'     => 'int',
            'label'    => 'My Category Attribute',
            'input'    => 'boolean',
            'source'   => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'visible'  => true,
            'default'  => '0',
            'required' => false,
            'global'   => ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'Display Settings',
        ]);

        $setup->addAttribute(Category::ENTITY, 'custom_image', [
            'type'     => 'varchar',
            'label'    => 'Custom Image',
            'input'    => 'image',
            'backend'  => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required' => false,
            'global'   => ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'General Information',
        ]);
    }
}
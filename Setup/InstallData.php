<?php

namespace Icovn\CategoryCustomAttribute\Setup;

use Magento\Catalog\Model\Category;

use Magento\Framework\Setup\LoggerInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    protected $logger;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        LoggerInterface $logger
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->logger = $logger;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->logInline("install Icovn_CategoryCustomAttribute");

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(Category::ENTITY, 'my_attribute', [
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

        $eavSetup->addAttribute(Category::ENTITY, 'custom_image', [
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
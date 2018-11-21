<?php
namespace Icovn\CategoryCustomAttribute\Setup;

use Magento\Customer\Model\Category;

use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Config;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\LoggerInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    /** @var TypeListInterface */
    private $cacheTypeList;

    /** @var Config */
    private $eavConfig;

    protected $logger;

    /**
     * @param Config $eavConfig
     * @param AttributeRepositoryInterface $attributeRepository
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        Config $eavConfig,
        AttributeRepositoryInterface $attributeRepository,
        TypeListInterface $cacheTypeList,
        LoggerInterface $logger
    ) {
        $this->eavConfig = $eavConfig;
        $this->attributeRepository = $attributeRepository;
        $this->cacheTypeList = $cacheTypeList;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @throws LocalizedException
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->logInline("upgradeData Icovn_CategoryCustomAttribute");
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            print("version: " . $context->getVersion());
            $this->deleteCustomAttribute();
        }

        $setup->endSetup();
    }

    /**
     * Deletes the "customer_code" custom attribute, if created
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\StateException
     */
    private function deleteCustomAttribute()
    {
        $attribute = $this->getEntityAttribute(Category::ENTITY, 'attribute_id');
        if (!$attribute) {
            return;
        }
        $this->attributeRepository->delete($attribute);
    }

    /**
     * Retrieve an entity attribute
     *
     * @param string $entity
     * @param string $attributeCode
     * @return \Magento\Eav\Model\Entity\Attribute\AbstractAttribute|void
     * @throws LocalizedException
     */
    private function getEntityAttribute($entity, $attributeCode)
    {
        if (method_exists($this->eavConfig, 'getEntityAttributes')) {
            $attributes = $this->eavConfig->getEntityAttributes($entity);
            if (!isset($attributes[$attributeCode])) {
                return;
            }

            return $attributes[$attributeCode];
        }

        $attributeCodes = $this->eavConfig->getEntityAttributeCodes($entity);
        if (!in_array($attributeCode, $attributeCodes)) {
            return;
        }

        return $this->eavConfig->getAttribute($entity, $attributeCode);
    }
}
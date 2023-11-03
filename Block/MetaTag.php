<?php
namespace CustomMagentoModule\IdentifyPageMultiStore\Block;

use Magento\Cms\Model\Page as CmsPage;
use Magento\Cms\Model\ResourceModel\Page as ResourceModelPage;
use Magento\Cms\Helper\Page as CmsPageHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

class MetaTag extends Template
{
    public const PATH_LOCALE_CODE_CONFIG = 'general/locale/code';

    /**
     * MetaTag constructor
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param CmsPage $cmsPage
     * @param CmsPageHelper $cmsPageHelper
     * @param ResourceModelPage $cmsPageResourceModel
     * @param array $data
     */
    public function __construct(
        Context $context,
        private readonly StoreManagerInterface $storeManager,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly CmsPage $cmsPage,
        private readonly CmsPageHelper $cmsPageHelper,
        private readonly ResourceModelPage $cmsPageResourceModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Return store language
     *
     * @param string $storeId
     * @return string|null
     */
    public function getStoreLanguage(string $storeId): ?string
    {
        return strtolower($this->scopeConfig->getValue(
            static::PATH_LOCALE_CODE_CONFIG,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * Return store base url
     *
     * @param string $storeId
     * @return string
     */
    public function getStoreBaseUrl(string $storeId): string
    {
        return $this->storeManager->getStore($storeId)->getBaseUrl(UrlInterface::URL_TYPE_WEB);
    }

    /**
     * Return cms page url
     *
     * @return string
     */
    public function getCmsPageUrl(): string
    {
        $cmsPagePath = "";
        if ($this->cmsPage->getId()) {
            $pageId = $this->cmsPage->getId();
            $cmsPagePath = $this->cmsPageHelper->getPageUrl($pageId);
            $cmsPagePath = str_replace($this->getBaseUrl(), "", $cmsPagePath);
        }

        return $cmsPagePath;
    }

    /**
     * Return cms page stores
     *
     * @return array
     */
    public function getCmsPageStores(): array
    {
        $cmsPageStoreList = $this->cmsPage->getStores();
        if ($this->cmsPage->getId()) {
            $cmsPageStoreList = $this->cmsPageResourceModel->lookupStoreIds($this->cmsPage->getId());
        }

        return $cmsPageStoreList;
    }
}

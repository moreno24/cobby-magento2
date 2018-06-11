<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 18.05.18
 * Time: 11:46
 */

namespace Mash2\Cobby\Test\Unit\Model;

use Mash2\Cobby\Model\ConfigManagement;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Store\Model\Store\Interceptor;

class ConfigManagementTest extends TestCase
{
    private $config;
    private $scopeConfig;
    private $storeManager;
    private $url;
    private $productMetadata;
    protected $_testHelper;
    private $storeInterceptor;


    protected function setUp()
    {
        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)->getMockForAbstractClass();
        $this->storeManager = $this->getMockBuilder(StoreManagerInterface::class)->getMockForAbstractClass();
        $this->url = $this->getMockBuilder(UrlInterface::class)->getMockForAbstractClass();
        $this->productMetadata = $this->getMockBuilder(ProductMetadataInterface::class)->getMockForAbstractClass();
        $this->storeInterceptor = $this->getMockBuilder(Interceptor::class)->setMethods(['getId', 'getBaseUrl'])->getMock();

        $this->config = new ConfigManagement(
            $this->scopeConfig,
            $this->storeManager,
            $this->url,
            $this->productMetadata
        );


    }


    public function testGetList()
    {
        $this->productMetadata->expects($this->once())->method('getEdition')->will($this->returnValue(false));
        $this->productMetadata->expects($this->once())->method('getVersion')->will($this->returnValue(123));

        $this->url->adminhtml="www.someUrl.com'";
        $this->url->expects($this->once())->method('turnOffSecretKey')->will($this->returnValue($this->url));
        $this->url->expects($this->once())->method('getUrl')->will($this->returnValue('www.someUrl.com'));

        $this->storeManager->stores = array($this->storeInterceptor);
        $this->storeManager->expects($this->any())->method('getStores')->will($this->returnValue(array($this->storeInterceptor)));

        $this->storeInterceptor->expects($this->any())->method('getBaseUrl')->will($this->returnValue('baseUrl'));
        $this->storeInterceptor->expects($this->any())->method('getId')->will($this->returnValue(0));

        $this->scopeConfig->expects($this->any())->method('getValue')->will($this->returnValue('someScope'));


        $storeConfigs[] = array(
            'store_id' => 0,
            'web/unsecure/base_url' => 'baseUrl',
            'cobby/settings/admin_url' => 'www.someUrl.com',
            'mage/core/enterprise' => false,
            'mage/core/magento_version' => 123,
            'cobby/settings/overwrite_images' => 'someScope',
            'cobby/settings/cobby_version' => 'someScope',
            'cobby/settings/clear_cache' => 'someScope',
            'web/unsecure/base_media_url' => 'baseUrl',
            'cataloginventory/item_options/manage_stock' => 'someScope',
            'cataloginventory/item_options/backorders' => 'someScope',
            'cataloginventory/item_options/min_qty' => 'someScope',
            'cobby/stock/manage' => 'someScope'
        );

        $this->assertEquals($storeConfigs, $this->config->getList());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 18.05.18
 * Time: 11:46
 */

namespace Mash2\Cobby\Test\Unit\Model;

use Klarna\Core\Exception;
use Magento\Framework\App\ProductMetadata;
use Mash2\Cobby\Model\ConfigManagement;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ProductMetadataInterface;

class ConfigManagementTest extends TestCase
{
    private $config;
    private $scopeConfig;
    private $storeManager;
    private $url;
    private $productMetadata;
    protected $_testHelper;


    protected function setUp()
    {
        $helper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->url = $helper->getObject(UrlInterface::class);
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);

        $this->storeManager = $this->createMock(StoreManagerInterface::class);

       // $this->url = $this->createMock(UrlInterface::class);

        $this->productMetadata = $this->createMock(ProductMetadataInterface::class);



//        $this->scopeConfig = $this->getMockForAbstractClass(
//            'Magento\Framework\App\Config\ScopeConfigInterface',
//            [],
//            '',
//            false,
//            true,
//            true,
//            ['getValue']
//        );
//
//        $this->storeManager = $this->getMockForAbstractClass(
//            'Magento\Store\Model\StoreManagerInterface',
//            [],
//            '',
//            false,
//            true,
//            true,
//            ['getStores']
//        );
//
//        $this->url = $this->getMockForAbstractClass(
//            'Magento\Backend\Model\UrlInterface',
//            [],
//            '',
//            false,
//            true,
//            true,
//            ['turnOffSecretKey', 'getUrl']
//        );
//
//        $this->productMetadata = $this->getMockForAbstractClass(
//            'Magento\Framework\App\ProductMetadataInterface',
//            [],
//            '',
//            false,
//            true,
//            true,
//            ['getEdition', 'getVersion']
//        );
//

        $this->config = new ConfigManagement(
            $this->scopeConfig,
            $this->storeManager,
            $this->url,
            $this->productMetadata
        );


    }


    public function testFailGetList()
    {

        /*
         * http://magento.local:8080/index.php/admin/admin/ getUrl
         *
         *
         *
         *
         */

        $realBackendUrl = new UrlInterface();

        $this->scopeConfig->expects($this->once())->method('getValue')->willReturn([]);
        $this->storeManager->expects($this->once())->method('getStores')->willReturn([0, 1]);
        $this->url->expects($this->once())->method('getUrl')->willReturn($realBackendUrl->turnOffSecretKey()->getUrl('adminhtml'));
        $this->productMetadata->expects($this->once())->method('getEdition')->willReturn(false);
        $this->productMetadata->expects($this->once())->method('getVersion')->willReturn('2.2.3');

        $storeConfigs = array(
            'store_id' => '',
            'web/unsecure/base_url' => '',
            'cobby/settings/admin_url' => '',
            'mage/core/enterprise' => false,
            'mage/core/magento_version' => null
        );

        //$this->expectException(\Error::class);
        //$this->assertEquals($storeConfigs, $this->config->getList());

        $list = $this->config->getList();

        foreach ($list as $store) {
            $this->assertEquals(
                $storeConfigs,
                $store['store_id']
            );
        }

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 18.05.18
 * Time: 11:46
 */

namespace Mash2\Cobby\Test;

use Klarna\Core\Exception;
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

    protected function setUp()
    {

        $this->scopeConfig = $this->getMockForAbstractClass(
            'Magento\Framework\App\Config\ScopeConfigInterface',
            [],
            '',
            false,
            true,
            true,
            ['getValue']
        );

        $this->storeManager = $this->getMockForAbstractClass(
            'Magento\Store\Model\StoreManagerInterface',
            [],
            '',
            false,
            true,
            true,
            ['getStores']
        );

        $this->url = $this->getMockForAbstractClass(
            'Magento\Backend\Model\UrlInterface',
            [],
            '',
            false,
            true,
            true,
            ['turnOffSecretKey', 'getUrl']
        );

        $this->productMetadata = $this->getMockForAbstractClass(
            'Magento\Framework\App\ProductMetadataInterface',
            [],
            '',
            false,
            true,
            true,
            ['getEdition', 'getVersion']
        );

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
        //$this->scopeConfig->expects($this->once())->method('getValue')->willReturn([]);
        //$this->storeManager->expects($this->once())->method('getStores')->willReturn([0, 1]);
        //$this->url->expects($this->once())->method('getUrl')->willReturn(null);
        //$this->productMetadata->expects()->method('getEdition', 'getVersion')->willReturn(null);

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

//        foreach ($list as $store) {
//            $this->assertEquals(
//                $storeConfigs,
//                $store['store_id']
//            );
//        }

    }
}

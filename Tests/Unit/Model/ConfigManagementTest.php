<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 18.05.18
 * Time: 11:46
 */

namespace Mash2\Cobby\Tests;

use Mash2\Cobby\Model\ConfigManagement;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ProductMetadataInterface;

class ConfigManagementTest extends TestCase
{


    public function testGetList(): void
    {
        $config = new ConfigManagement(
            ScopeConfigInterface,
            StoreManagerInterface,
            UrlInterface,
            ProductMetadataInterface
            );

        $list = $config->getList();
        $this->assertEquals(
            'id',
            $list['id']
        );
    }
}

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

class ConfigManagementTest extends TestCase
{
    public function testGetList()
    {
        $config = $this->getMockBuilder(ConfigManagement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $list = $config->getList();

        foreach ($list as $store) {
            $this->assertEquals(
                0,
                $store['store_id']
            );
        }

    }
}

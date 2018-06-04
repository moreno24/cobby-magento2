<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 04.06.18
 * Time: 09:17
 */

namespace Mash2\Cobby\Test\Unit\Model;

use Mash2\Cobby\Model\ProductManagement;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Event\ManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class ProductManagementTest extends TestCase
{
    protected $eventManager;
    protected $productCollectionFactory;
    protected $productManagement;
    protected $objectManagerHelper;

    protected function setUp()
    {
        $this->eventManger = $this->getMockBuilder(
            ManagerInterface::class)
        ->getMockForAbstractClass();

        $this->productCollectionFactory = $this->createPartialMock(
            CollectionFactory::class,
            ['create']
        );

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->productManagement = $this->objectManagerHelper->getObject(ProductManagement::class, []);
    }

    public function testGetList()
    {
        //$this->eventManager->expects($this->any())->method('dispatch')->will($this->returnValue('test'));

        $list = $this->productManagement->getList(0, 1024);

        $this->assertEquals(true, is_array($list));

    }
}
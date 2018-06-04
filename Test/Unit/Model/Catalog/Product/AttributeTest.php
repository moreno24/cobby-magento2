<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 04.06.18
 * Time: 10:58
 */

namespace Mash2\Cobby\Test\Unit\Model\Catalog\Product;

use Magento\Framework\Exception\NoSuchEntityException;
use Mash2\Cobby\Model\Catalog\Product\Attribute;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Framework\Event\ManagerInterface;

class AttributeTest extends TestCase
{
    protected $collection;
    protected $product;
    protected $managerInterface;
    protected $attribute;

    protected function setUp()
    {
        $this->collection = $this->getMockBuilder(
            Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'setAttributeSetFilter'])
            ->getMock()
        ;

        $this->product = $this->getMockBuilder(
            Product::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAttribute'])
            ->getMock()
        ;

        $this->managerInterface = $this->getMockBuilder(ManagerInterface::class)->getMockForAbstractClass();

        $this->attribute = new Attribute(
            $this->collection,
            $this->product,
            $this->managerInterface
        );
    }
    public function testExportExceptionNoSetId()
    {
        $this->collection->expects($this->once())->method('setAttributeSetFilter');
        $this->collection->expects($this->once())->method('load')->will($this->returnValue(
            ['items' => ['blub' => 'blab',
                'blab' => 'blub']]
        ));

        $this->product->expects($this->once())->method('getAttribute')->will($this->returnValue(["attribute" => "attribute"]));

        $this->managerInterface->expects($this->once())->method('dispatch');

        $this->attribute->export(1,1);

        $this->expectException(Exception::class);
        //$this->assertEquals([], $list);

    }

    public function testExportExceptionNoAttrId()
    {
        $this->product->expects($this->once())->method('getAttribute')->will($this->returnValue(false));
        //$this->expectException(Exception::class);
        try {
            $this->attribute->export(1, 1);
        } catch (\Throwable $e) {
        }

    }

    public function testExportEmpty()
    {
        $this->assertEmpty($this->attribute->export());
    }
}
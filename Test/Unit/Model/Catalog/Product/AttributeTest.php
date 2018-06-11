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
    private $attributeMock;

    protected function setUp()
    {
        $this->collection = $this->getMockBuilder(
            Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['setAttributeSetFilter', 'load'])
            ->getMock()
        ;

        $this->product = $this->getMockBuilder(
            Product::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAttribute'])
            ->getMock()
        ;

        $this->managerInterface = $this->getMockBuilder(ManagerInterface::class)->getMockForAbstractClass();

        $this->attributeMock = $this->getMockBuilder(
            Attribute::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFrontendLabel', 'getStoreLabels', 'getData', 'getScope', 'getApplyTo', 'getItems'])
            ->getMock()
        ;

        $this->attribute = new Attribute(
            $this->collection,
            $this->product,
            $this->managerInterface
        );
    }

    public function testExportAttribute()
    {
        $this->product->expects($this->once())->method('getAttribute')->will($this->returnValue($this->attributeMock));

        $this->attributeMock->expects($this->once())->method('getFrontendLabel')->will($this->returnValue('blub'));
        $this->attributeMock->expects($this->once())->method('getStoreLabels')->will($this->returnValue([]));
        $this->attributeMock->expects($this->once())->method('getData')->will($this->returnValue([]));
        $this->attributeMock->expects($this->once())->method('getScope')->will($this->returnValue('scope'));
        $this->attributeMock->expects($this->once())->method('getApplyTo')->will($this->returnValue('nothing'));

        $stores[] = array('store_id' => 0, 'label' => 'blub');
        $expected[] = array(
            'scope' => 'scope',
            'apply_to' => 'nothing',
            'store_labels' => $stores
        );

        $this->assertEquals($expected, $this->attribute->export(null, 1));
    }

    public function testExportAttributeSet()
    {
        $attribute = new AttributeHelper();
        $this->collection->expects($this->once())->method('setAttributeSetFilter')->will($this->returnValue($this->collection));
        $this->collection->expects($this->any())->method('load')->will($this->returnValue($attribute->getObjects($this->attributeMock)));

        $this->attributeMock->expects($this->once())->method('getItems')->will($this->returnValue($this->attributeMock));


        $this->attributeMock->expects($this->once())->method('getFrontendLabel')->will($this->returnValue('blub'));
        $this->attributeMock->expects($this->once())->method('getStoreLabels')->will($this->returnValue([]));
        $this->attributeMock->expects($this->once())->method('getData')->will($this->returnValue([]));
        $this->attributeMock->expects($this->once())->method('getScope')->will($this->returnValue('scope'));
        $this->attributeMock->expects($this->once())->method('getApplyTo')->will($this->returnValue('nothing'));

        $this->managerInterface->expects($this->once())->method('dispatch');

        $list = $this->attribute->export($attributeSetId= 1);

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

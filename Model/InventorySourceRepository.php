<?php

namespace Mash2\Cobby\Model;


class InventorySourceRepository implements \Mash2\Cobby\Api\InventorySourceRepositoryInterface
{
    private $sources;

    public function __construct(
        \Magento\InventoryImportExport\Model\Export\Sources $sources
    ){
        $this->sources = $sources;
    }


    public function export()
    {
        $result = array();

        $sources = $this->sources->export();


        return $result;
    }
}
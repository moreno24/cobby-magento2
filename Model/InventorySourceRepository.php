<?php

namespace Mash2\Cobby\Model;


class InventorySourceRepository implements \Mash2\Cobby\Api\InventorySourceRepositoryInterface
{
    private $sources;

    public function __construct(
        \Magento\Inventory\Model\SourceRepository $sources
    ){
        $this->sources = $sources;
    }


    public function export()
    {
        $result = array();
        $reponseModel = [
            'source_code' => '',
            'enabled' => $data['enabled'],
            'name' => $data['name']
        ];

        $sources = $this->sources->getList()->getItems();

        foreach ($sources as $source => $data) {
            $result[$source] = [
                                'source_code' => $data['source_code'],
                                'enabled' => $data['enabled'],
                                'name' => $data['name']
                ];
        }


        return $result;
    }
}
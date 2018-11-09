<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 09.11.18
 * Time: 12:00
 */

namespace Mash2\Cobby\Observer;

use Magento\Framework\Event\ObserverInterface;

class ExportProduct implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();

        foreach ($data as $productId => $productData) {
            $productData['_type'] = 'simple1';
            $result[$productId] = $productData;
         }

         $observer->getTransport()->setData($result);

        return $this;
    }
}
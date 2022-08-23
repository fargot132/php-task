<?php

namespace Recruitment\ViewCreator;

use Recruitment\Entity\Order;

class TaxViewCreator implements ViewCreatorInterface
{

    /**
     * @inheritDoc
     */
    public function getDataForView(Order $order): array
    {
        $data = ['id' => $order->getId(), 'items' => [], 'total_price' => 0, 'total_price_gross' => 0];
        foreach ($order->getItems() as $item) {
            $data['items'][] = [
                'id' => $item->getProduct()->getId(),
                'price' => $item->getProduct()->getUnitPrice(),
                'tax' => sprintf("%d%%", $item->getProduct()->getTax()),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice(),
                'total_price_gross' => $item->getTotalPriceGross()
            ];
            $data['total_price'] += $item->getTotalPrice();
            $data['total_price_gross'] += $item->getTotalPriceGross();
        }
        return $data;
    }
}

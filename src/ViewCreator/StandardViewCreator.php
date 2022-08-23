<?php

namespace Recruitment\ViewCreator;

use Recruitment\Entity\Order;

class StandardViewCreator implements ViewCreatorInterface
{

    /**
     * @inheritDoc
     */
    public function getDataForView(Order $order): array
    {
        $data = ['id' => $order->getId(), 'items' => [], 'total_price' => 0];
        foreach ($order->getItems() as $item) {
            $data['items'][] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice()
            ];
            $data['total_price'] += $item->getTotalPrice();
        }
        return $data;
    }
}

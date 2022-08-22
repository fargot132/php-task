<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        $data = ['id' => $this->getId(), 'items' => [], 'total_price' => 0];
        foreach ($this->getItems() as $item) {
            $data['items'][] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice()
            ];
            $data['total_price'] += $item->getTotalPrice();
        }
        return $data;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}

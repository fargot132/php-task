<?php

namespace Recruitment\Cart;

use Recruitment\Entity\Product;

class Cart
{
    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        if ($item = $this->getItemByProductId($product->getId())) {
            $item->addQuantity($quantity);
        } else {
            $this->items[] = new Item($product, $quantity);
        }
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;
        foreach ($this->getItems() as $item) {
            $totalPrice += $item->getProduct()->getUnitPrice() * $item->getQuantity();
        }
        return $totalPrice;
    }

    public function getItem($id): Item
    {
        return $this->getItems()[$id];
    }


    /**
     * @param int $productId
     * @return null|int
     */
    private function getItemKeyByProductId(int $productId): ?int
    {
        foreach ($this->getItems() as $key => $item) {
            if ($item->getProduct()->getId() === $productId) {
                var_dump(['------key----------' => $key]);
                return $key;
            }
        }
        return null;
    }

    /**
     * @param int $productId
     * @return Item|null
     */
    private function getItemByProductId(int $productId): ?Item
    {
        if (null !== ($key = $this->getItemKeyByProductId($productId))) {
            return $this->getItem($key);
        }
        return null;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function removeProduct(Product $product): bool
    {
        if (false !== ($key = $this->getItemKeyByProductId($product->getId()))) {
            unset($this->items[$key]);
            return true;
        }
        return false;
    }
}

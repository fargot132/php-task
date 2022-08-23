<?php

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Order;
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
            $totalPrice += $item->getTotalPrice();
        }
        return $totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $totalPriceGross = 0;
        foreach ($this->getItems() as $item) {
            $totalPriceGross += $item->getTotalPriceGross();
        }
        return $totalPriceGross;
    }

    /**
     * @param int $id
     * @return Item
     */
    public function getItem(int $id): Item
    {
        if (isset($this->getItems()[$id])) {
            return $this->getItems()[$id];
        }
        throw new OutOfBoundsException();
    }


    /**
     * @param int $productId
     * @return int|null
     */
    private function getItemKeyByProductId(int $productId): ?int
    {
        foreach ($this->getItems() as $key => $item) {
            if ($item->getProduct()->getId() === $productId) {
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
     * @return Cart
     */
    public function removeProduct(Product $product): Cart
    {
        if (null !== ($key = $this->getItemKeyByProductId($product->getId()))) {
            unset($this->items[$key]);
            $this->items = array_values($this->items);
        }
        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     * @throws Exception\QuantityTooLowException
     */
    public function setQuantity(Product $product, int $quantity): Cart
    {
        if ($item = $this->getItemByProductId($product->getId())) {
            $item->setQuantity($quantity);
        } else {
            $this->addProduct($product, $quantity);
        }
        return $this;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function checkout(int $orderId): Order
    {
        $order =  new Order($orderId, $this->getItems());
        $this->clear();
        return $order;
    }

    /**
     * @return $this
     */
    public function clear(): Cart
    {
        $this->items = [];
        return $this;
    }
}

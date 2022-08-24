<?php

namespace Recruitment\Cart;

use InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        if ($product->getMinimumQuantity() > $quantity) {
            throw new InvalidArgumentException();
        }
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->getProduct()->getUnitPrice() * $this->getQuantity();
    }

    /**
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        return round($this->getTotalPrice() * (1 + $this->getProduct()->getTax() / 100));
    }

    /**
     * @return int
     */
    public function getTaxValue(): int
    {
        return round($this->getTotalPrice() * ($this->getProduct()->getTax() / 100));
    }

    /**
     * @param int $quantity
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): void
    {
        if ($this->getProduct()->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException();
        }
        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     * @return Item
     * @throws QuantityTooLowException
     */
    public function addQuantity(int $quantity): Item
    {
        $this->setQuantity($this->getQuantity() + $quantity);
        return $this;
    }

    /**
     * @param int $quantity
     * @return Item
     * @throws QuantityTooLowException
     */
    public function substractQuantity(int $quantity): Item
    {
        $this->setQuantity($this->getQuantity() + $quantity);
        return $this;
    }
}

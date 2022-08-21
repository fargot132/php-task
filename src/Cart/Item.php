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

    public function addQuantity(int $quantity)
    {
        $this->setQuantity($this->getQuantity() + $quantity);
    }

    public function substractQuantity(int $quantity)
    {
        $this->setQuantity($this->getQuantity() + $quantity);
    }
}

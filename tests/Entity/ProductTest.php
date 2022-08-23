<?php

declare(strict_types=1);

namespace Recruitment\Tests\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Recruitment\Entity\Exception\InvalidTaxValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;
use Recruitment\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsExceptionForInvalidUnitPrice(): void
    {
        $this->expectException(InvalidUnitPriceException::class);
        $product = new Product();
        $product->setUnitPrice(0);
    }

    /**
     * @test
     */
    public function itThrowsExceptionForInvalidMinimumQuantity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product();
        $product->setMinimumQuantity(0);
    }

    /**
     * @test
     */
    public function itThrowsExceptionForInvalidTaxValue(): void
    {
        $this->expectException(InvalidTaxValueException::class);
        $product = new Product();
        $product->setTax(3);
    }

    /**
     * @test
     */
    public function itAcceptsConstructorArgumentAndReturnsData(): void
    {
        $product = new Product(new TestTaxValidator());
        $product->setId(22)
            ->setName('Test name')
            ->setTax(10)
            ->setMinimumQuantity(5)
            ->setUnitPrice(123);

        $this->assertEquals(22, $product->getId());
        $this->assertEquals('Test name', $product->getName());
        $this->assertEquals(10, $product->getTax());
        $this->assertEquals(5, $product->getMinimumQuantity());
        $this->assertEquals(123, $product->getUnitPrice());
    }
}

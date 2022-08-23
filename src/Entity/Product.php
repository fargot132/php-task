<?php

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Entity\Exception\InvalidTaxValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;
use Recruitment\Tax\PolandTaxValidator;
use Recruitment\Tax\TaxValidatorInterface;

class Product
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $unitPrice = 0;

    /**
     * @var int
     */
    private $minimumQuantity = 1;

    /**
     * @var int
     */
    private $tax = 0;
    /**
     * @var TaxValidatorInterface
     */
    private $taxValidator;

    public function __construct(?TaxValidatorInterface $taxValidator = null)
    {
        if (null === $taxValidator) {
            $taxValidator = new PolandTaxValidator();
        }
        $this->taxValidator = $taxValidator;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if ($unitPrice > 0) {
            $this->unitPrice = $unitPrice;
            return $this;
        }
        throw new InvalidUnitPriceException();
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): Product
    {
        if ($minimumQuantity > 0) {
            $this->minimumQuantity = $minimumQuantity;
            return $this;
        }
        throw new InvalidArgumentException;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     * @return Product
     * @throws InvalidTaxValueException
     */
    public function setTax(int $tax): Product
    {
        if ($this->taxValidator->isTaxValid($tax)) {
            $this->tax = $tax;
            return $this;
        }
        throw new InvalidTaxValueException();
    }
}

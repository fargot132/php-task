<?php
namespace Recruitment\Tests\Entity;

use Recruitment\Tax\TaxValidatorInterface;

class TestTaxValidator implements TaxValidatorInterface
{
    /**
     * @return int[]
     */
    public function getTaxes(): array
    {
        return [0, 1, 10, 15];
    }

    /**
     * @param int $tax
     * @return bool
     */
    public function isTaxValid(int $tax): bool
    {
        return in_array($tax, $this->getTaxes());
    }
}

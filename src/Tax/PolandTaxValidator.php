<?php

namespace Recruitment\Tax;

class PolandTaxValidator implements TaxValidatorInterface
{
    /**
     * @return int[]
     */
    public function getTaxes(): array
    {
        return [0, 5, 8, 23];
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

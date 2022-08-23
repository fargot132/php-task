<?php

namespace Recruitment\Tax;

interface TaxValidatorInterface
{
    /**
     * @return int[]
     */
    public function getTaxes(): array;

    /**
     * @param int $tax
     * @return bool
     */
    public function isTaxValid(int $tax): bool;
}

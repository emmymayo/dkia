<?php

namespace App\Contracts\Cbt;

interface CalculatesCbtResult {

    /**
     * Calculates Cbt result from Eloquent collection
     *
     * @return string
     */
    public function calculate();

}
<?php

namespace App\validator;

use App\exception\ApplicationException;

class Validator
{
    public function numberValidator(string $type): \Closure
    {
        return function (int $value) use ($type) {
            if ($value <= 0) {
                throw new ApplicationException("$type must be greater than 0", 400);
            }
        };
    }
}
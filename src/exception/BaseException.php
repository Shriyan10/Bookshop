<?php

namespace App\exception;

use Exception;
use Throwable;

interface BaseException {


    public function message(): string;

    public function status(): int;

    public function throwable(): Throwable| null;
}

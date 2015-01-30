<?php

namespace AdamQuaile\Betterpress\Bridge\Php\Constants;

use AdamQuaile\Betterpress\Constants\ConstantManager;
use AdamQuaile\Betterpress\Constants\Exceptions\ConstantAlreadyDefined;
use AdamQuaile\Betterpress\Constants\Exceptions\ConstantNotDefined;

class PhpConstantManager implements ConstantManager
{
    public function set($key, $value)
    {
        if (defined($key)) {
            throw new ConstantAlreadyDefined($key);
        }
        define($key, $value);
    }

    public function get($key)
    {
        if (!defined($key)) {
            throw new ConstantNotDefined($key);
        }

        return constant($key);
    }

}
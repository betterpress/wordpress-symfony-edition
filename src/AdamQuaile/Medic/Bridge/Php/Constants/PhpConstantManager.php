<?php

namespace AdamQuaile\Medic\Bridge\Php\Constants;

use AdamQuaile\Medic\Constants\ConstantManager;
use AdamQuaile\Medic\Constants\Exceptions\ConstantAlreadyDefined;
use AdamQuaile\Medic\Constants\Exceptions\ConstantNotDefined;

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
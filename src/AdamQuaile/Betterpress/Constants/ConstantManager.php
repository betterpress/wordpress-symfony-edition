<?php

namespace AdamQuaile\Betterpress\Constants;

interface ConstantManager
{
    /**
     * @param $key
     * @param $value
     * @return void
     * @throws Exceptions\ConstantAlreadyDefined
     */
    public function set($key, $value);

    /**
     * @param $key
     * @return mixed
     * @throws Exceptions\ConstantNotDefined
     */
    public function get($key);
}
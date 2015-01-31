<?php

namespace Betterpress\Shortcode;

class ShortcodeContext
{
    private $userAttributes;
    private $resolvedAttributes;

    public function __construct($userAttributes, $resolvedAttributes)
    {
        $this->userAttributes = $userAttributes;
        $this->resolvedAttributes = $resolvedAttributes;
    }

    /**
     * @return mixed
     */
    public function getResolvedAttributes()
    {
        return $this->resolvedAttributes;
    }

}